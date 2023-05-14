<?php

namespace App\Listeners;

use App\Events\DeviceBinded;
use App\Entities\DailyGas;
use App\Entities\GasHistory;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;

class HideGasData
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
        GasHistory::where('device_id', $event->device->id)
                ->where('when', '<', Carbon::now())
                ->delete();

        DailyGas::where('device_id', $event->device->id)
                ->where('when', '<', Carbon::now())
                ->delete();
    }
}
