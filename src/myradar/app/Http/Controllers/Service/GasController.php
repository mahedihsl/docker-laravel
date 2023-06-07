<?php

namespace App\Http\Controllers\Service;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\DailyGasRepository;
use App\Criteria\DeviceIdCriteria;
use App\Criteria\NRecordsCriteria;
use App\Criteria\ExactDateCriteria;
use App\Criteria\AfterWhenCriteria;
use App\Criteria\BeforeWhenCriteria;
use App\Criteria\LastUpdatedCriteria;
use App\Presenters\DailyGasPresenter;
use App\Entities\Device;
use App\Events\GasRefueled;
use Carbon\Carbon;
use Exception;

class GasController extends Controller
{
    /**
     * @var DailyGasRepository
     */
    private $dailyRepo;

    public function __construct(DailyGasRepository $dailyRepo)
    {
        $this->dailyRepo = $dailyRepo;
    }

    public function onRefuel(Request $request)
    {
        try {
            $deviceId = $request->get('device_id');
            $range = $request->get('range');
            $device = Device::find($deviceId);
            if (is_null($device)) {
                throw new Exception("Device not found with id: {$deviceId}");
            }

            event(new GasRefueled($device, $range));
            return response()->json('Refuel event processed');
        } catch (\Exception $th) {
            return response()->error($th->getMessage());
        }
    }

    public function latest(Request $request, $id)
    {
        // If this is demo car
        if ($id == '5f63fbca32ebd87dc663002a') {
            return response()->json([
                'id' => '...',
                'value' => 2,
                'when' => Carbon::today()->format('j M'),
            ]);
        }

        $device = Device::with(['car'])->find($id);
        if (!$device->car->status) {
            return response()->json(['value' => 0]);
        }

        $this->dailyRepo->setPresenter(DailyGasPresenter::class);
        $this->dailyRepo->pushCriteria(new DeviceIdCriteria($id));
        $this->dailyRepo->pushCriteria(new LastUpdatedCriteria());

        $item = $this->dailyRepo->skipPresenter()->first();
        if (!is_null($item)) {
            return response()->json($item->presenter());
        }

        return response()->json(['value' => 0]);
    }

    /**
     * Api for Web & Mobile client
     * @param  Request $request [description]
     * @param  string  $id      device id
     * @param  integer $day     number of days
     * @return array            [description]
     */
    public function history(Request $request, $id, $day)
    {
        $device = Device::with(['car'])->find($id);
        if (!$device->car->status) {
            return response()->json(['items' => []]);
        }

        $this->dailyRepo->pushCriteria(new DeviceIdCriteria($id));
        $this->dailyRepo->pushCriteria(new BeforeWhenCriteria(Carbon::today()));

        return response()->json([
            'items' => $this->filterGasValues($day, Carbon::yesterday())
        ]);
    }

    /**
     * Api for Mobile client
     * @param  Request $request [description]
     * @param  string  $id      device id
     * @return array            [description]
     */
    public function archive(Request $request, $id)
    {
        $device = Device::with(['car'])->find($id);
        if (!$device->car->status) {
            return response()->json(['items' => []]);
        }

        $from = Carbon::createFromFormat('Y-n-j', $request->get('from'));
        $to = Carbon::createFromFormat('Y-n-j', $request->get('to'));

        $day = $from->diffInDays($to) + 1;
        $from->setTime(0, 0, 0);
        $to->setTime(0, 0, 0);

        $this->dailyRepo->pushCriteria(new DeviceIdCriteria($id));
        $this->dailyRepo->pushCriteria(new BeforeWhenCriteria($to->copy()->addDay()));
        $this->dailyRepo->pushCriteria(new AfterWhenCriteria($from->copy()->subDay()));

        return response()->json([
            'items' => $this->filterGasValues($day, $to)
        ]);
    }

    private function filterGasValues($day, $from)
    {
        $this->dailyRepo->setPresenter(DailyGasPresenter::class);

        $this->dailyRepo->pushCriteria(new LastUpdatedCriteria());
        $this->dailyRepo->pushCriteria(new NRecordsCriteria($day));

        $items = $this->dailyRepo->skipPresenter()->all(['when', 'value']);
        for ($i = 0; $i < $day && $i < $items->count(); $i++) {
            $model = $items->get($i);
            $date = $from->copy()->subDays($i);

            if (!$model->when->eq($date)) {
                $temp = $model->presenter()['data'];
                $temp['when'] = $date->format('j M');
                $items->splice($i, 0, [$temp]);
            }
        }

        return $items->take($day)->map(function ($item) {
            return is_array($item) ? $item : $item->presenter()['data'];
        });
    }
}
