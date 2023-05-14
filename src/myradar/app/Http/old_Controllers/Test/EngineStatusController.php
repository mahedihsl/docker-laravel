<?php

namespace App\Http\Controllers\Test;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entities\Device;
use App\Entities\User;
use App\Events\EngineStatusChanged;
use App\Events\SpeedLimitCrossEvent;
use App\Listeners\SpeedLimitCrossListener;
use App\Service\OneSignalService;
use App\Jobs\PushNotificationJob;
use App\Listeners\NotifyEngineStatus;

class EngineStatusController extends Controller
{
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
        $event = new EngineStatusChanged($device, 1);
        $listener = new NotifyEngineStatus();
        $listener->handle($event);
        $res->push('Engine ON notification sent, Check with customer');
      }
      $res->push('Diagnosis finished');
    }
    // event(new SpeedLimitCrossEvent($device, $limit, $flag));
    return view('test.engine-noti')->with([
      'messages' => $res,
    ]);
  }
}
