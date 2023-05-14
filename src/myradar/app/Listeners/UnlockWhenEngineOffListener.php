<?php

namespace App\Listeners;

use App\Events\UnlockWhenEngineOffEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Entities\Device;
use App\Service\Microservice\ET200Microservice;
use App\Service\Microservice\JT808Microservice;

class UnlockWhenEngineOffListener
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
     * @param  UnlockWhenEngineOffEvent  $event
     * @return void
     */
    public function handle(UnlockWhenEngineOffEvent $event)
    {
        $event->device->update([ 'lock_status' => Device::$STATUS_UNLOCKED ]);

        try {
            $service = new ET200Microservice();
            $service->unlock($event->device->com_id);
        } catch (\Exception $th) {}

        try {
            $service = new JT808Microservice();
            $service->unlock($event->device->com_id);
        } catch (\Exception $th) {}
    }
}
