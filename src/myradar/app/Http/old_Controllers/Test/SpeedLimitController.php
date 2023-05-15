<?php

namespace App\Http\Controllers\Test;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entities\Device;
use App\Entities\User;
use App\Events\SpeedLimitCrossEvent;
use App\Listeners\SpeedLimitCrossListener;
use App\Service\OneSignalService;
use App\Jobs\PushNotificationJob;
use App\Service\Microservice\SpeedMicroservice;

class SpeedLimitController extends Controller
{
  public function diagnose(Request $request)
  {
    $service = new SpeedMicroservice();
    $data = $service->test([
      'car_id' => $request->get('car_id'),
      'speed' => $request->get('speed'),
    ]);
    return response()->json($data);
  }

  public function noti(Request $request)
  {
    $res = collect();
    $com_id = intval($request->com_id);
    if ($com_id) {
      $res->push('Starting diagnosis');
      $device = Device::where('com_id', $com_id)->first();
      
      if (is_null($device)) {
        $res->push('Device not found');
      } else {
        $res->push('Device found in DB');
        $limit = intval($request->get('speed'));
        $flag = 1;
        $event = new SpeedLimitCrossEvent($device, $limit, $flag);
        $listener = new SpeedLimitCrossListener();
        $res = $res->concat($this->trace($event, $listener));
      }
      $res->push('Diagnosis finished');
    }
    // event(new SpeedLimitCrossEvent($device, $limit, $flag));
    return view('test.speed-noti')->with([
      'messages' => $res,
    ]);
  }

  private function trace($event, $listener) {
    $arr = collect();
    if (is_null($event->device->user)) {
      $arr->push('Device is not connected with an user');
      return $arr;
    }

    $arr->push('Device is connected with user: ' . $event->device->user->name);

    if (is_null($event->device->car)) {
      $arr->push('Device is not connected with a car');
      return $arr;
    }

    $arr->push('Device is connected with car: ' . $event->device->car->reg_no);

    $deliverable = $listener->deliverable($event->device->car, $event->limit, $event->flag);
    if (!$deliverable) {
      $arr->push('Notification is not deliverable');
      return $arr;
    }

    $arr->push('Deliverable check is passed');
    
    $data = $listener->payload($event);
    $arr->push(json_encode($data));

    $private = $event->device->user->customer_type == User::$CUSTOMER_PRIVATE;
    $arr->push('Customer type is: ' . ($private ? 'private' : 'enterprise'));

    if ($private && !($fl = $listener->privateValidate($event->device->user))) {
      $arr->push('Private customer settings problem, speed notification = ' . $fl);
      return $arr;
    }

    $arr->push('Private customer settings are ok');

    $delivered = $listener->execute($event->device->user, $event->device, $data);

    $arr->push('Notification delivery response: ' . $delivered);

    return $arr;
  }
}
