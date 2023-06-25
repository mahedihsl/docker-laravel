<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\UserRepository;
use App\Service\Microservice\UserMicroservice;
use App\Criteria\WithTypeCriteria;
use App\Criteria\UserNameCriteria;
use App\Criteria\PhoneNumberCriteria;
use App\Presenters\UserActivityPresenter;
use App\Entities\User;
use App\Entities\Activity;
use App\Service\Microservice\ServiceException;
use Carbon\Carbon;
use Excel;
use App\Exports\CustomerEngagementExport;

class EngagementController extends Controller
{
    private $repository;

    private $userService;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
        $this->repository->pushCriteria(new WithTypeCriteria(User::$TYPE_CUSTOMER));

        $this->userService = new UserMicroservice();
    }

    public function index(Request $request)
    {


        $name = $request->get('name', '');
        $phone = $request->get('phone', '');

        $this->repository->pushCriteria(new UserNameCriteria($name));
        $this->repository->pushCriteria(new PhoneNumberCriteria($phone));

        $records = $this->repository->paginate(20);
        return view('report.engagement')->with([
            'items' => $records,
            'params' => collect([
                'name' => $name,
                'phone' => $phone,
            ])
        ]);
    }

    public function login(Request $request, $id)
    {
        $user = User::find($id);

        if ( ! is_null($user)) {
            $data = $user->getLatestActivity();
            return response()->ok([
                $data[0]['l'],
                $data[1]['l'],
                $data[2]['l'],
            ]);
        }

        return response()->error();
    }

    public function request(Request $request, $id)
    {
        $user = User::find($id);

        if ( ! is_null($user)) {
            $data = $user->getLatestActivity();
            return response()->ok([
                $data[0]['r'],
                $data[1]['r'],
                $data[2]['r'],
                $data[3]['r'],
                $data[4]['r'],
                $data[5]['r'],
                $data[6]['r'],
            ]);
        }

        return response()->error();
    }

    public function export(Request $request)
    {

        $users = $this->repository->all(['name', 'phone']);

        $data = $this->records($users, $request->all());


        return Excel::download(new CustomerEngagementExport($data) , 'test(API Count).xls');

        // Excel::create('CustomerEngagement (API Count)', function ($excel) use ($data) {
        //     $excel->sheet('data', function ($sheet) use ($data) {
        //         $sheet->fromArray($data->toArray(), null, 'A1', false, true);
        //     });
        // })->download('xls');

        // return redirect()->back();
    }

    private function records($users, $query)
    {
		$uids = $users->map(function($u) { return $u->id; })->toArray();


        $year = intval($query['year']);
        $month = intval($query['month']);
        $startDate = Carbon::createFromDate($year, $month, 1);
        $startDate->setTime(0, 0, 0);
        $endDate = $startDate->copy()->addMonth();




		$activities = Activity::where('user_id',$uids)
			->where('when', '>=', $startDate)
			->where('when', '<', $endDate)
			->get()
			->groupBy(function ($val) {
				return $val->user_id;
			});




        // return $activities;

       $test=$users->map(function ($user) use ($activities, $startDate, $endDate) {
            $data = collect($activities->get($user->id));


            $ret = [
                'Name' => $user->name,
                // 'Phone' => $user->phone,
                'Cars' => 0, // $user->cars()->count()
            ];

			for ($i=$startDate->copy(); $i->lessThan($endDate); $i->addDay()) {
				$itm = $data->first(function($val, $key) use ($i) {
					return $val->when->equalTo($i);
				});

				$xx = 0;
				$yy = 0;
				if ( ! is_null($itm)) {
					$xx = $itm->request;
					 $yy = $itm->login;
				}

				$str = $i->format('j M');
				$arr = [
					$str => $xx,
					 $str.'(OPEN)' => $yy,
				];

				$ret = array_merge($ret, $arr);
			}
            return $ret;
        });


    }

	public function test() {

	}

    public function smsPack1Enabler(Request $request)
    {
        try {
            $data = $this->userService->scanUnderengagedUsers();
            Excel::create('SMS Pack1 Altered Users (Engagement)', function ($excel) use ($data) {
                $excel->sheet('data', function ($sheet) use ($data) {
                    $sheet->fromArray($data, null, 'A1', false, true);
                });
            })->download('xls');
            return redirect()->back();
        } catch (ServiceException $e) {
            return response()->json([ 'error' => $e->getMessage() ]);
        }
    }
}
