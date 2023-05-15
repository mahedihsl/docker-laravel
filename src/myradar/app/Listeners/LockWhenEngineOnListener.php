<?php

namespace App\Listeners;

use App\Events\LockWhenEngineOnEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Entities\Device;
use App\Service\Microservice\ET200Microservice;
use App\Service\Microservice\JT808Microservice;

class LockWhenEngineOnListener
{
    /**
     * @var SmsService
     */
    // private $service;

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
     * @param  LockWhenEngineOnEvent  $event
     * @return void
     */
    public function handle(LockWhenEngineOnEvent $event)
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
    }
}
