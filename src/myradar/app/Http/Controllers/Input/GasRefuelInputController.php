<?php

namespace App\Http\Controllers\Input;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\Car;
use App\Entities\Device;
use App\Entities\Event;
use App\Entities\GasRefuelInput;
use Carbon\Carbon;

class GasRefuelInputController extends Controller
{
    public function setPriceFactorByUser(Request $request)
    {
      $deviceId = $request->get('id');
      $price = $request->get('price');
      $eventId = $request->get('eventId');

      $device = Device::find($deviceId);
      if(is_null($device)){
        return response()->error("No device found");
      }

      $car = $device->car;
      if(is_null($car)){
        return response()->error("No car found for this device");
      }

      //$meta = $this->metaOfClosestEvent($car->id, $time);
      $meta = $this->findEvent($eventId);
      if($meta == -1){
        return response()->error("No events found");
      }

      if(!isset($meta['base'])){
        $meta['base'] = null;
      }

      $priceFactor = $price/abs($meta['magnitude']);
      $inputs =[
        'device_id' => $deviceId,
        'car_id' => $car->id,
        'price' => $price,
        'base'=> $meta['base'],
        'magnitude' => $meta['magnitude'],
        'event_id' => $eventId,
        'factor' => $priceFactor,
      ];
      GasRefuelInput::create($inputs);
      return response()->json();
    }

    public function findEvent($eventId)
    {
      //$event = Event::where('_id', $eventId)->first();
      $event = Event::find($eventId);
      if(is_null($event)){
        return -1;
      }
      $event->save();
      return $event->meta;
    }

    public function metaOfClosestEvent($carId, $time)
    {
      $eventMeta1 = Event::where('car_id',$carId)->where('type',3)->where('created_at', '>=' , $time)->orderBY('created_at', 'asc')->first();
      $eventMeta2 = Event::where('car_id',$carId)->where('type',3)->where('created_at', '<=' , $time)->first();

      $timeDiff1 = $this->getTimeDiff($eventMeta1, $time);
      $timeDiff2 = $this->getTimeDiff($eventMeta2, $time);

      $event1 = $this->isValid($eventMeta1, $time);
      $event2 = $this->isValid($eventMeta2, $time);
      $validEvent = null;

      if(!$event1 && !$event2)
        return -1;
      else if(!$event1)
        $validEvent = $eventMeta2->meta;
      else if(!$event2)
        $validEvent = $eventMeta1->meta;
      else{
        if($timeDiff1 < $timeDiff2)
          $validEvent = $eventMeta1->meta;
        else
          $validEvent = $eventMeta2->meta;
      }


      return $validEvent;
    }

    public function getTimeDiff($eventMeta, $time)
    {
      $timeDiff = null;
      if(!is_null($eventMeta))
        $timeDiff = $eventMeta->created_at->diffInMinutes($time);

      return $timeDiff;
    }

    public function isValid($eventMeta, $time)
    {
      if(is_null($eventMeta))
        return false;

      if($eventMeta->created_at->diffInMinutes($time) <= 120)
        return true;

      return false;
    }
}
