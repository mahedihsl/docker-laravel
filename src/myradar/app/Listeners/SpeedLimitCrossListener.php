<?php

namespace App\Listeners;

use App\Events\SpeedLimitCrossEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Entities\User;
use App\Entities\Setting;

use Carbon\Carbon;
use App\Service\NotificationService;
use App\Jobs\PushNotificationJob;
use App\Service\Microservice\PushMicroservice;

class SpeedLimitCrossListener
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
     * @param  SpeedLimitCrossEvent  $event
     * @return void
     */
    public function handle(SpeedLimitCrossEvent $event)
    {
        if (is_null($event->device->user)) {
            return;
        }

        if ($this->deliverable($event->device->car, $event->limit, $event->flag)) {
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
        $service = new PushMicroservice();
        $service->send($user->id, $data);
        return true;
      }
      return false;
    }

    public function getBody($limit, $flag)
    {
        $status = $flag ? 'above' : 'below';
        return "Car is running {$status} {$limit} km/h";
    }

    public function payload($event)
    {
      return collect([
          'title' => $event->title(),
          'body' => $event->body(),
          'type' => NotificationService::$TYPE_SPEED,
      ]);
    }

    public function deliverable($car, $speed, $flag)
    {
        if ( ! $flag) {
            return false;
        }

        $limits = $car->speed_limit;
        if ($limits['soft']['value'] == $speed) {
            return $limits['soft']['flag'];
        } else if ($limits['hard']['value'] == $speed) {
            return $limits['hard']['flag'];
        }

        return false;
        // return ($speed == 60 && $flag);
    }


      public function enterpriseValidate($user, $car){
        try {
            $settings = Setting::where('user_id',$user->id)
                                ->where('car_id',$car->id)
                                ->first();

            return is_null($settings) || $settings->noti_speed;
        } catch (\Exception $e) {
            return FALSE;
        }
      }

      public function privateValidate($user){
        try {
            $settings = Setting::where('user_id',$user->id)
                                ->first();

            return is_null($settings) || $settings->noti_speed;
        } catch (\Exception $e) {
            return FALSE;
        }
      }
}
