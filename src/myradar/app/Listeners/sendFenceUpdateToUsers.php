<?php

namespace App\Listeners;

use App\Events\FenceEnterExit;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Http\Controllers\PushNotification\PushNotificationController;
use App\Entities\Fence;
use App\Entities\UserLogin;
use Carbon\Carbon;

class sendFenceUpdateToUsers
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->PushNotification = new PushNotificationController();
    }

    /**
     * Handle the event.
     *
     * @param  FenceEnterExit  $event
     * @return void
     */
    public function handle(FenceEnterExit $event)
    {
        $device= $event->device;
        $fence_status_array = $event->fence_status_array;
        $user = $device->user;
        $type = 3; //push type

        $device_token_type_array = UserLogin::where('user_id', $user->id)->get()->map(function ($item) {
            $array[$item->device_token] = $item->device_type;
            return $array;
        })->toArray();

        $ios_device_tokens = [];
        $android_device_tokens = [];

        foreach ($device_token_type_array as $device):
              foreach ($device as $token=>$device_type):
                if ($device_type==1) {
                    array_push($ios_device_tokens, $token);
                } else {
                    array_push($android_device_tokens, $token);
                }
               endforeach;
        endforeach;

        $message = "";
        $title = "";

        foreach ($fence_status_array as $fence_id=>$status):
        $fence = Fence::find($fence_id);
        if ($status==0) { //exit
            $message = $fence->name." Exit ".
            $title = "Geofence Exit at ".Carbon::now()->format('g:i A');
        } elseif ($status==1) {//enter
            $message = $fence->name." Entered ".
            $title = "Geofence Entered at ".Carbon::now()->format('g:i A');
        }
        endforeach;


        if (!empty($ios_device_tokens)) {
            $this->PushNotification->iosPush($message, $title, $ios_device_tokens, $vibrate=1, $sound=1, $type);
        }

        if (!empty($android_device_tokens)) {
            $this->PushNotification->androidPush($message, $title, $android_device_tokens, $vibrate=1, $sound=1, $type);
        }

        // if (!empty($ios_device_tokens)) {
        //     //$this->PushNotification->iosPush($message, $title, $ios_device_tokens, $vibrate=1, $sound=1, $type);
        //     foreach($ios_device_tokens as $token):
        //       $this->PushNotification->iosPushSingle($message, $title, $token,$user->id,$vibrate=1, $sound=1, $type);
        //     endforeach;
        // }
        //
        // if (!empty($android_device_tokens)) {
        //     // $this->PushNotification->androidPush($message, $title, $android_device_tokens, $vibrate=1, $sound=1, $type);
        //     foreach($android_device_tokens as $token):
        //       $this->PushNotification->androidPushSingle($message, $title, $token,$user->id,$vibrate=1, $sound=1, $type);
        //     endforeach;
        // }
    }
}
