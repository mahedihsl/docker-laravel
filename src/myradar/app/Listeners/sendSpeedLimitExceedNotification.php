<?php

namespace App\Listeners;

use App\Events\SpeedLimitExceeded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Http\Controllers\PushNotification\PushNotificationController;
use App\Entities\UserLogin;
use Carbon\Carbon;
class sendSpeedLimitExceedNotification
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
     * @param  SpeedLimitExceeded  $event
     * @return void
     */
    public function handle(SpeedLimitExceeded $event)
    {

        $user = $event->user;
        $speed = $event->speed;
        $limit = $event->limit;
        $flag = $event->flag;

        $device_token_type_array = $user->user_logins->map(function($item){
               $array[$item->device_token] =isset($item->device_type)?$item->device_type:0; //if no device_type --> android
               return $array;
        })->toArray();

       $type = 4 ;//speed violation
       $ios_device_tokens = [];
       $android_device_tokens = [];
        if($flag==1)
        {
          $message ="Car Exceeded Speed Limit ".$limit.' km/h ';
          $title =  " Speed : ".$speed." km/h ".Carbon::now()->format('g:i A');
        }
        else if($flag==0)
        {
            $message ="Car has is running below Speed Limit ".$limit.' km/h ';
            $title =  " Speed ".$speed." km/h ".Carbon::now()->format('g:i A');
        }

        foreach ($device_token_type_array as $device):
              foreach ($device as $token=>$device_type):
                if ($device_type==1) {
                    array_push($ios_device_tokens, $token);
                } else {
                    array_push($android_device_tokens, $token);
                }
               endforeach;
        endforeach;
        if (!empty($ios_device_tokens)) {
            $this->PushNotification->iosPush($message, $title, $ios_device_tokens, $vibrate=1, $sound=1, $type);
            // foreach($ios_device_tokens as $token):
            //   $this->PushNotification->iosPushSingle($message, $title, $token,$user->id,$vibrate=1, $sound=1, $type);
            // endforeach;
        }

        if (!empty($android_device_tokens)) {

             $this->PushNotification->androidPush($message, $title, $android_device_tokens, $vibrate=1, $sound=1, $type);
            // foreach($android_device_tokens as $token):
            //   $this->PushNotification->androidPushSingle($message, $title, $token,$user->id,$vibrate=1, $sound=1, $type);
            // endforeach;
        }

        // if (!empty($ios_device_tokens)) {
        //     $this->PushNotification->iosPush($message, $title, $ios_device_tokens, $vibrate=1, $sound=1, $type);
        // }
        //
        // if (!empty($android_device_tokens)) {
        //     $this->PushNotification->androidPush($message, $title, $android_device_tokens, $vibrate=1, $sound=1, $type);
        // }

    }
}
