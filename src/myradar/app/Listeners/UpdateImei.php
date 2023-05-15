<?php

namespace App\Listeners;

use App\Events\DeviceHealthReceived;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateImei
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
     * @param  DeviceHealthReceived  $event
     * @return void
     */
    public function handle(DeviceHealthReceived $event)
    {
        $updates = [];
        if ($event->hasImei() && $event->device->imei != $event->getImei()) {
            $updates['imei'] = $event->getImei();
        }
        $version = trim($event->getDeviceVersion());
        if (strlen($version) > 0) {
            $updates['version'] = $version;
        }

        if (count($updates)) {
            $event->device->update($updates);
        }
    }
}
