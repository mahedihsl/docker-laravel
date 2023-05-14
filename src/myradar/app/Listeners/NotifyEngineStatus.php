<?php

namespace App\Listeners;

use App\Events\EngineStatusChanged;
use App\Service\NotificationService;
use App\Service\OneSignalService;
use App\Jobs\PushNotificationJob;
use App\Entities\User;
use App\Entities\Setting;
use App\Service\Microservice\PushMicroservice;
use App\Service\Microservice\DeviceMicroservice;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class NotifyEngineStatus
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NotifyEngineStatus  $event
     * @return void
     */
    public function handle(EngineStatusChanged $event)
    {
        if($event->silent || is_null($event->device->car) || is_null($event->device->user)){
          return;
        }
        //send notification to original owners
        $user = $event->device->user;
        $device  = $event->device;
        $data = $this->payload($event);
        $this->execute($user, $device, $data);

        // send notification to users with whom the car is shared
        $users = $device->car->shared_with;
        foreach ($users as $key => $userId) {
          $this->execute(User::find($userId), $device, $data);
        }
    }

    public function execute($user, $device, $data){
      $customerType = $user->customer_type;
      $car = $device->car;
      $validated = $customerType == User::$CUSTOMER_ENTERPRISE ? $this->enterpriseValidate($user, $car) : $this->privateValidate($user);

      if ($validated) {
          $userId = $user->id;
          $data   = $data;
          $this->sendNotification($user, $device, $data);
      }
    }


    public function sendNotification($user, $device, $data)
    {
    //   $service = new PushMicroservice();
    //   $service->send($user->id, $data);
        try {
            $service = new DeviceMicroservice();
            $service->consumeEngineStatus($device->com_id, $data->get('status'));
        } catch (\Exception $e) {
            //throw $th;
        }
    }

    public function payload($event)
    {
        $label = $event->status ? 'ON' : 'OFF';
        $time = Carbon::now()->format('g:i A');

        return collect([
            'title'     => "Alert for car: {$event->device->car->reg_no}",
            'body'      => "Your car was {$label} at {$time}",
            'status'    => $event->device->engine_status,
            'type'      => NotificationService::$TYPE_ENGINE,
            'car_id'    => $event->device->car_id,
        ]);
    }

    public function enterpriseValidate($user, $car){
      try {
          $settings = Setting::where('user_id',$user->id)
                              ->where('car_id',$car->id)
                              ->first();

          return is_null($settings) || $settings->noti_engine;
      } catch (\Exception $e) {
          return FALSE;
      }
    }

    public function privateValidate($user){
      try {
          $settings = Setting::where('user_id',$user->id)->first();

          return is_null($settings) || $settings->noti_engine;
      } catch (\Exception $e) {
          return FALSE;
      }
    }

    public function isDeliverable($event)
    {
        if ($event->silent) {
            return FALSE;
        }

        try {
            $settings = $event->device->user->settings;

            return is_null($settings) || $settings->noti_engine;
        } catch (\Exception $e) {
            return FALSE;
        }

    }
}
