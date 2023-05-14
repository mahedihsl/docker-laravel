<?php

namespace App\Http\Controllers\Promotion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\NoticeRepository;
use App\Entities\User;
use App\Entities\Notice;
use App\Entities\Payment;
use App\Jobs\PushNotificationJob;
use App\Service\NotificationService;
use Carbon\Carbon;
use App\Entities\PendingNotice;
use App\Service\Microservice\PushMicroservice;
use App\Service\Microservice\SmsMicroservice;
use App\Service\OneSignalService;
use App\Transformers\PendingNoticeTransformer;
use Illuminate\Support\Facades\Log;
use Exception;
use Excel;

class NoticeController extends Controller
{
    private $repository;

    public function __construct(NoticeRepository $repository)
    {
        $this->repository = $repository;
    }

    private function unpaidUsersOfMonth($mm, $yy)
    {
        $date = Carbon::createFromDate($yy, $mm, 1);
        $date->setTime(0, 0);

        $mm--;

        $users = Payment::where('months', 'all', [[$mm, $yy]])
            ->orWhere('months', 'all', [[$mm, strval($yy)]])
            ->get(['user_id'])
            ->map(function ($v) {
                return $v->user_id;
            })
            ->toArray();

        $unpaid = User::where('type', User::$TYPE_CUSTOMER)
            ->where('created_at', '<', $date)
            ->whereNotIn('_id', $users)
            ->where(function ($query) {
                $query->where('status', 'exists', false)
                    ->orWhere('status', 1)
                    ->orWhere('status', "1");
            })
            ->get(['phone', 'account_type', 'customer_type']);

        return $unpaid->filter(function($user) {
            $excludedTypes = ['rms_manager'];
            return !in_array($user->account_type, $excludedTypes);
        });
    }

    // $mm = month (1 indexed)
    private function getUnpaidUsers($mm, $yy)
    {
        $phoneNumbers = collect();
        for ($i = 0; $i < 36; $i++) {
            $numbers = $this->unpaidUsersOfMonth($mm, $yy);
            $phoneNumbers = $phoneNumbers->concat($numbers);
            $mm--;
            if ($mm == 0) {
                $mm = 1;
                $yy--;
            }
        }
        return $phoneNumbers->unique()->values();
    }

    public function test(Request $request)
    {
        $month = explode(",", $request->get('month'));
        $mm = intval($month[0]);
        $yy = intval($month[1]);

        $phones = $this->getUnpaidUsers($mm, $yy);
        return [
            'count' => $phones->count(),
            'phones' => $phones,
        ];
    }

    public function sendDueNotice(Request $request)
    {
        $month = explode(",", $request->get('month'));
        $mm = intval($month[0]);
        $yy = intval($month[1]);
        $via = $request->get('via');

        $message = $request->get('message', null);

        if (strlen($message)) {
            $unpaid = $this->getUnpaidUsers($mm, $yy);

            $notice = $this->repository->create([
                'message' => $message,
                'via' => $via,
                'pending' => $unpaid->count(),
                'sent' => 0,
                'failed' => 0,
            ]);

            $unpaid->each(function ($user) use ($message, $via, $notice) {
                if ($via == 'sms') {
                    PendingNotice::create([
                        'via' => $via,
                        'to' => $user->phone,
                        'payload' => $message,
                        'notice_id' => $notice->id,
                        'attempt' => 0,
                    ]);
                } else {
                    PendingNotice::create([
                        'via' => $via,
                        'to' => $user->id,
                        'payload' => [
                            'title' => 'Notice',
                            'body' => $message,
                            'type' => NotificationService::$TYPE_BILL,
                        ],
                        'notice_id' => $notice->id,
                        'attempt' => 0,
                    ]);
                }
            });

            return redirect()->route('due-notice', [
                'status' => 1,
                'via' => $via,
                'notice_id' => $notice->id,
                'count' => PendingNotice::where('via', $via)->count(),
            ]);
        }

        return redirect()->route('due-notice', ['status' => 0]);
    }

    public function exportDueNotice(Request $request, $via)
    {
        $notices = PendingNotice::where('via', $via)->get();
        $targets = $notices->map(function ($v) {
            return $v->to;
        });

        $foreignField = $via == 'sms' ? 'phone' : '_id';
        $users = User::whereIn($foreignField, $targets)->get();

        $fileName = 'Pending Notices - ' . strtoupper($via);
        Excel::create($fileName, function ($excel) use ($notices, $users) {
            $excel->sheet('data', function ($sheet) use ($notices, $users) {
                $notices->transform(function ($notice) use ($users) {
                    $user = $users->first(function ($user) use ($notice) {
                        if ($notice->via == 'sms') {
                            return $user->phone == $notice->to;
                        }
                        return $user->id == $notice->to;
                    });
                    $transformer = new PendingNoticeTransformer();
                    return $transformer->transform($notice, $user);
                });

                $sheet->fromArray($notices->toArray(), null, 'A1', false, true);
            });
        })->download('xlsx');
    }

    public function sendSingleNotice(Request $request)
    {
        $via = $request->get('via', 'none');
        // $notice_id = $request->get('notice_id');
        $model = PendingNotice::where('via', $via)
            ->where('attempt', 0)
            ->first();
        if (!is_null($model)) {
            try {
                $notice = $this->repository->find($model->notice_id);
                $sent = 1;
                if ($model->via == 'sms') {
                    $s = new SmsMicroservice();
                    $reply = $s->send(strval($model->to), str_replace("\r\n", "\n", $model->payload), 'due_bill');
                    $sent = $reply['status'];
                } else if ($model->via == 'push') {
                    $service = new PushMicroservice();
                    $res = $service->send($model->to, collect($model->payload));

                    $socketRecipients = $res['recipients']['socket'];
                    $oneSignalRecipients = $res['recipients']['onesignal'];
                    $sent = $socketRecipients + $oneSignalRecipients;
                }
                if ($sent > 0) {
                    $model->delete();
                    $notice->increment('sent');
                } else {
                    $model->increment('attempt');
                    $notice->increment('failed');
                }
                $notice->decrement('pending');
                return response()->json([
                    'sent' => $sent,
                    'remaining' => PendingNotice::where('via', $via)
                        ->where('attempt', 0)
                        ->count(),
                ]);
            } catch (Exception $error) {
                Log::info('Single Notice Delivery Error', [
                    'message' => $error->getMessage(),
                    'model' => $model->toArray(),
                ]);
                return response()->json(['message' => $error->getMessage(), 'model' => $model], 400);
            }
        }
        return response()->json(['message' => 'Could not send notice'], 400);
    }

    public function dueNotice(Request $request)
    {
        $counts = collect(['sms', 'push'])->mapWithKeys(function ($tag) {
            return [
                $tag => PendingNotice::where('via', $tag)->count(),
            ];
        });

        $months = collect(range(0, 11))->map(function ($i) {
            $temp = Carbon::today()->subMonths($i);
            return [
                'value' => $temp->format('n,Y'),
                'label' => $temp->format('F Y'),
            ];
        });
        $history = Notice::orderBy('_id', 'desc')
            ->limit(10)
            ->paginate();

        return view('promotion.notice')->with([
            'months' => $months,
            'history' => $history,

            'counts' => $counts,
        ]);
    }

    public function clear(Request $request)
    {
        $tag = $request->get('via');
        PendingNotice::where('via', $tag)->delete();

        return redirect('/due/notice');
    }
}
