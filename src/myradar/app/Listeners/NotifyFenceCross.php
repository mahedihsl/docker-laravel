<?php

namespace App\Listeners;

use App\Events\FenceCrossEvent;
use App\Service\NotificationService;
use App\Jobs\PushNotificationJob;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Entities\User;
use App\Entities\Setting;
use App\Service\Microservice\PushMicroservice;

class NotifyFenceCross
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
     * @param  FenceCrossEvent  $event
     * @return void
     */
    public function handle(FenceCrossEvent $event)
    {
        //$settings = $event->device->user->settings;
        if( ! $event->isTypeBus()){
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
    }

    public function execute($user, $device, $data){
      $customerType = $user->customer_type;
      $car = $device->car;
      $validated = $customerType == User::$CUSTOMER_ENTERPRISE ? $this->enterpriseValidate($user, $car) : $this->privateValidate($user);

      if ($validated) {
          $userId = $user->id;
          $data   = $data;
          $this->sendNotification($userId, $device, $data);
      }

    }

    public function sendNotification($userId, $device, $data)
    {
      $service = new PushMicroservice();
      $service->send($userId, $data);
    }

    public function payload($event){

      return collect([
          'title' => $event->getTitle(),
          'body' => $event->getBody(),
          'type' => NotificationService::$TYPE_FENCE,
      ]);
    }

    public function enterpriseValidate($user, $car){
      try {
          $settings = Setting::where('user_id',$user->id)
                              ->where('car_id',$car->id)
                              ->first();

          return is_null($settings) || $settings->noti_geofence;
      } catch (\Exception $e) {
          return FALSE;
      }
    }

    public function privateValidate($user){
      try {
          $settings = Setting::where('user_id',$user->id)
                              ->first();

          return is_null($settings) || $settings->noti_geofence;
      } catch (\Exception $e) {
          return FALSE;
      }
    }
}
