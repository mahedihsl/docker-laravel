<?php

namespace App\Http\Controllers\Enterprise;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\EventRepository;
use App\Contract\Repositories\PositionRepository;
use App\Criteria\CarIdCriteria;
use App\Criteria\DeviceIdCriteria;
use App\Criteria\DateRangeCriteria;
use App\Criteria\ModelTypeCriteria;
use App\Criteria\OrderByIdCriteria;
use App\Criteria\WithinDatesCriteria;
use App\Entities\Event;
use App\Entities\Device;
use Carbon\Carbon;

class TrackingController extends Controller
{
    private $repository;

    public function __construct(PositionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function route(Request $request, $id)
    {
        $device = Device::find($id);
        $date = $request->get('date');
        $date = Carbon::createFromFormat('m-d-Y', $date);
        $path = $this->repository
            ->skipPresenter()
            ->pushCriteria(new DeviceIdCriteria($id))
            ->pushCriteria(new WithinDatesCriteria($date, $date->copy(), 'when'))
            ->pushCriteria(new OrderByIdCriteria())
                ->all()
                    ->map(function($item) {
                        return [
                            'lat'       => $item->lat,
                            'lng'       => $item->lng,
                            'status'    => null,
                            'time'      => $item->when->timestamp,
                        ];
                    });

        $events = resolve(EventRepository::class)
            ->skipPresenter()
            ->pushCriteria(new CarIdCriteria($device->car_id))
            ->pushCriteria(new WithinDatesCriteria($date, $date->copy()))
            ->pushCriteria(new ModelTypeCriteria([Event::TYPE_ON, Event::TYPE_OFF]))
            ->pushCriteria(new OrderByIdCriteria())
                ->all()
                    ->map(function($item) {
                        return [
                            'status' => intval($item->type == Event::TYPE_ON),
                            'time' => $item->created_at->timestamp,
                        ];
                    });

        return response()->json([
            'path' => $path,
            'events' => $events,
        ]);
    }
}
