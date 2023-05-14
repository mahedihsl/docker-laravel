<?php

namespace App\Listeners;

use App\Events\DeviceBinded;
use App\Entities\Mileage;
use App\Entities\Position;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;

class HideLatLngData
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
     * @param  DeviceBinded  $event
     * @return void
     */
    public function handle(DeviceBinded $event)
    {
        Position::where('device_id', $event->device->id)
                ->where('when', '<', Carbon::now())
                ->delete();

        Mileage::where('device_id', $event->device->id)
                ->where('when', '<', Carbon::now())
                ->delete();

        $event->device->update([ 'meta.pos' => null ]);
    }
}
