<?php

namespace App\Http\Controllers\Service;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\DailyFuelRepository;
use App\Criteria\DeviceIdCriteria;
use App\Criteria\NRecordsCriteria;
use App\Criteria\ExactDateCriteria;
use App\Criteria\DateRangeCriteria;
use App\Criteria\AfterWhenCriteria;
use App\Criteria\BeforeWhenCriteria;
use App\Criteria\LastUpdatedCriteria;
use App\Presenters\DailyFuelPresenter;
use App\Entities\Device;
use App\Service\Microservice\FuelMicroservice;
use App\Service\Microservice\ServiceException;
use Carbon\Carbon;

class FuelController extends Controller
{
    /**
     * @var DailyFuelRepository
     */
    private $dailyRepo;
    private $fuelService;

    public function __construct(DailyFuelRepository $dailyRepo)
    {
        $this->dailyRepo = $dailyRepo;
        $this->fuelService = new FuelMicroservice();
    }

    public function latest(Request $request, $id)
    {
        // If this is demo car
        if ($id == '5f63fbca32ebd87dc663002a') {
            return response()->json([
                'id' => '...',
                'value' => 56,
                'when' => Carbon::today()->format('j M'),
            ]);
        }

        $device = Device::with(['car'])->find($id);
        if (!$device->car->status) {
            return response()->json(['value' => 0]);
        }

        $this->dailyRepo->setPresenter(DailyFuelPresenter::class);
        $this->dailyRepo->pushCriteria(new DeviceIdCriteria($id));
        $this->dailyRepo->pushCriteria(new LastUpdatedCriteria());

        $item = $this->dailyRepo->skipPresenter()->first();
        if ( ! is_null($item)) {
            return response()->json($item->presenter());
        }

        return response()->json(['value' => 0]);
    }

    public function latestv2(Request $request)
    {
        try {
            $car_id = $request->get('car_id', null);
            $device_id = $request->get('device_id', null);
            $data = $this->fuelService->latest($device_id, $car_id);
            return response()->json($data);
        } catch (ServiceException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
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
        if ($device->car->name == 'Demo') {
            return response()->json([ 'items' => $this->getDemoFuelHistory(7) ]);
        }

        $this->dailyRepo->pushCriteria(new DeviceIdCriteria($id));
        $this->dailyRepo->pushCriteria(new BeforeWhenCriteria(Carbon::today()));

        return response()->json([
            'items' => $this->filterFuelValues($day, Carbon::yesterday())
        ]);
    }

    /**
     * This is for the generator fuel meter webpage
     */
    public function historyv2(Request $request)
    {
        try {
            $car_id = $request->get('car_id');
            $type = $request->get('type');
            $days = 90;
            $data = $this->fuelService->history($car_id, $type);
            $events = $this->fuelService->getRefuelEvents($car_id, $days);
            return response()->json([
                'values' => $data,
                'events' => $events,
            ]);
        } catch (ServiceException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
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
            'items' => $this->filterFuelValues($day, $to)
        ]);
    }

    public function filterFuelValues($day, $from)
    {
        $this->dailyRepo->setPresenter(DailyFuelPresenter::class);

        $this->dailyRepo->pushCriteria(new LastUpdatedCriteria());
        $this->dailyRepo->pushCriteria(new NRecordsCriteria($day));

        $items = $this->dailyRepo->skipPresenter()->all();
        for ($i = 0; $i < $day && $i < $items->count(); $i++) {
            $model = $items->get($i);
            $date = $from->copy()->subDays($i);

            if ( ! $model->when->eq($date)) {
                $temp = $model->presenter()['data'];
                $temp['when'] = $date->format('j M');
                $items->splice($i, 0, [$temp]);
            }
        }

        return $items->take($day)->map(function($item) {
            return is_array($item) ? $item : $item->presenter()['data'];
        });
    }

    public function getDemoFuelHistory($days)
    {
        $values = [80, 95, 28, 45, 58, 72, 81];
        $result = [];
        $fromDate = Carbon::today();
        for ($i=0; $i < $days; $i++) { 
            $date = $fromDate->copy()->subDays($i);
            $result[] = [
                'id' => '--',
                'value' => $values[$i],
                'when' => $date->format('j M'),
            ];
        }
        return $result;
    }

    public function fetchGroups(Request $request)
    {
        try {
            return response()->json($this->fuelService->fetchGroups());
        } catch (ServiceException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function seedGroups(Request $request)
    {
        try {
            return response()->json($this->fuelService->seedGroups());
        } catch (ServiceException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
