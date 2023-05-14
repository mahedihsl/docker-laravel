<?php

namespace App\Listeners;

use App\Events\DeviceTokenReceived;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SyncDeviceToken
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
     * @param  DeviceTokenReceived  $event
     * @return void
     */
    public function handle(DeviceTokenReceived $event)
    {
        //
    }
}
