<?php

namespace App\Listeners;

use App\Events\DeviceHealthReceived;
use App\Events\ServiceStringReceived;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;

class UpdateDeviceLastPulse
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
     * @param  ServiceStringReceived  $event
     * @return void
     */
    // public function handle(ServiceStringReceived $event)
    // {
    //     $event->device->update([ 'last_pulse' => Carbon::now() ]);
    // }


    public function onDeviceHealth(DeviceHealthReceived $event)
    {
      $event->device->update([ 'last_pulse' => Carbon::now() ]);
    }

    public function onServiceString(ServiceStringReceived $event)
    {
      $event->device->update([ 'last_pulse' => Carbon::now() ]);
    }

    public function subscribe($events)
    {
      $events->listen(
        'App\Events\DeviceHealthReceived',
        'App\Listeners\UpdateDeviceLastPulse@onDeviceHealth'
      );

      $events->listen(
        'App\Events\ServiceStringReceived',
        'App\Listeners\UpdateDeviceLastPulse@onServiceString'
      );
    }
}
