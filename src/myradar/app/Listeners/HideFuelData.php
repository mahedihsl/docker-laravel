<?php

namespace App\Listeners;

use App\Events\DeviceBinded;
use App\Entities\DailyFuel;
use App\Entities\FuelHistory;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;

class HideFuelData
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
        FuelHistory::where('device_id', $event->device->id)
                ->where('when', '<', Carbon::now())
                ->delete();

        DailyFuel::where('device_id', $event->device->id)
                ->where('when', '<', Carbon::now())
                ->delete();
    }
}
