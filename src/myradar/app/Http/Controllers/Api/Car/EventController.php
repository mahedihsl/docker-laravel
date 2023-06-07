<?php

namespace App\Http\Controllers\Api\Car;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Criteria\ModeCriteria;
use App\Criteria\CarIdCriteria;
use App\Criteria\NRecordsCriteria;
use App\Criteria\EventTypeCriteria;
use App\Criteria\LastCreatedCriteria;
use App\Transformers\EventTransformer;
use App\Entities\Car;
use App\Entities\Event;
use App\Entities\GasRefuelInput;
use Carbon\Carbon;

class EventController extends Controller
{
    public function events(Request $request, $car)
    {
        $carModel = Car::find($car);
        if (!$carModel->status) {
            return response()->error('This car is not active');
        }
        
        $options = [
            'sort' => ['created_at' => -1],
            'limit' => 100,
            'projection' => [
                'title' => true,
                'body' => true,
                'type' => true,
                'meta' => true,
                'created_at' => true,
            ],
        ];
        $onOff = Event::raw(function($collection) use ($car, $options) {
            return $collection->find([
                '$and' => [
                    ['car_id' => ['$eq' => $car]],
                    ['mode' => ['$eq' => Event::MODE_PUBLIC]],
                    ['type' => ['$in' => [Event::TYPE_ON, Event::TYPE_OFF]]],
                ]
            ], $options);
        });
        $gas = Event::raw(function($collection) use ($car, $options) {
            return $collection->find([
                '$and' => [
                    ['car_id' => ['$eq' => $car]],
                    ['mode' => ['$eq' => Event::MODE_PUBLIC]],
                    ['type' => ['$eq' => Event::TYPE_REFUEL]],
                ]
            ], $options);
        });
        $fuel = Event::raw(function($collection) use ($car, $options) {
            return $collection->find([
                '$and' => [
                    ['car_id' => ['$eq' => $car]],
                    ['mode' => ['$eq' => Event::MODE_PUBLIC]],
                    ['type' => ['$eq' => Event::TYPE_FUEL_REFUEL]],
                ]
            ], $options);
        });
        $event_ids = array_merge(
            $onOff->map(function($val) {return $val->id;})->toArray(),
            $gas->map(function($val) {return $val->id;})->toArray(),
            $fuel->map(function($val) {return $val->id;})->toArray()
        );
        $inputs = GasRefuelInput::raw(function($collection) use ($event_ids) {
            return $collection->find([
                'event_id' => ['$in' => $event_ids]
            ], [
                'projection' => [
                    'event_id' => true,
                ],
            ]);
        });
        $events = $onOff->merge($gas)->merge($fuel);
        $events = $events->map(function($model) use ($inputs) {
            $tr = new EventTransformer();
            $ret = $tr->transform($model);
            $ret['input'] = $inputs->contains(function($item) use ($ret) {
                return $item->event_id == $ret['id'];
            });
            return $ret;
        });

        if ($carModel->name == 'Demo') {
            $events = $events->concat($this->getDemoGasRefuelEvents());
        }

        return response()->json([
            'items' => $events,
        ]);
    }

    public function getDemoGasRefuelEvents()
    {
        $result = [];
        $start = Carbon::now();
        for ($i=1; $i <= 10; $i++) { 
            $time = $start->copy()->subDays($i)->subHours(rand(1, 24));
            $result[] = [
                'id'    => '--',
                'title' => 'Alert for car: 88-8888',
                'body'  => 'Your car has taken gas of ' . rand(500, 1200) . ' Taka at ' . $time->format('g:i A'),
                'type'  => Event::TYPE_REFUEL,
                'meta'  => [], // only used in WebApp, Mobile App doesn't use this field
                'time'  => $time->format('j M Y'),
                'input' => true,
            ];
        }
        return $result;
    }
}
