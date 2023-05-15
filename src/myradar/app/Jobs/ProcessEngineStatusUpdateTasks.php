<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\App;
use Vinkla\Pusher\Facades\Pusher;
use App\Entities\Device;
use App\Entities\UserLogin;
use App\Http\Controllers\PushNotification\PushNotificationController;
use Carbon\Carbon;

class ProcessEngineStatusUpdateTasks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
     public $event_value;

    public function __construct($event_value)
    {

     $this->event_value = $event_value;


    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      $data = json_decode($this->event_value, true);
      $device_id = $data['device_id'];
      $user = Device::find($device_id)->user->id;

      $engine_status = $data['engine_status'];
      $lock_status = $data['lock_status'];

      //$device_tokens = [];
      $type = 2 ;//on /off
      $ios_device_tokens = [];
      $android_device_tokens = [];
      $device_token_type_array = [];

      $device_token_type_array = UserLogin::where('user_id', $user)->get()->map(function ($item) {
          $array[$item->device_token] = $item->device_type;
          return $array;
      });

      if ($engine_status==1) {
          $message = "Car ON";
          $title = "Your Car is ON ".Carbon::now()->format('g:i A');
      } elseif ($engine_status==0) {
          $message = "Car OFF";
          $title = "Your Car is OFF ".Carbon::now()->format('g:i A');
      }

      Pusher::trigger('map-channel-'.$user, 'engine-event', ['message' => ['engine_status'=>$engine_status]]);

      $this->PushNotification =new PushNotificationController();
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
          //   $this->PushNotification->iosPushSingle($message, $title, $token,$user,$vibrate=1, $sound=1, $type);
          // endforeach;
      }

      if (!empty($android_device_tokens)) {
          $this->PushNotification->androidPush($message, $title, $android_device_tokens, $vibrate=1, $sound=1, $type);
          // foreach($android_device_tokens as $token):
          //   $this->PushNotification->androidPushSingle($message, $title, $token,$user,$vibrate=1, $sound=1, $type);
          // endforeach;
      }
    }
}
