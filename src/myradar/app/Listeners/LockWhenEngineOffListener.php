<?php

namespace App\Listeners;

use App\Events\LockWhenEngineOffEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Entities\Device;
use App\Service\PusherService;
use App\Service\Microservice\ET200Microservice;
use App\Service\Microservice\JT808Microservice;

class LockWhenEngineOffListener
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
     * @param  LockWhenEngineOffEvent  $event
     * @return void
     */
    public function handle(LockWhenEngineOffEvent $event)
    {
        $event->device->update([ 'lock_status' => Device::$STATUS_LOCKED ]);

        try {
            $service = new ET200Microservice();
            $service->lock($event->device->com_id);
        } catch (\Exception $th) {}
        
        try {
            $service = new JT808Microservice();
            $service->lock($event->device->com_id);
        } catch (\Exception $th) {}

        $notify = new PusherService();
        $notify->onEngineOff($event->device);
    }
}
