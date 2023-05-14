<?php

namespace App\Listeners;

use App\Events\GasCalibrationCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SetGasCalibrationMethod
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
     * @param  GasCalibrationCreated  $event
     * @return void
     */
    public function handle(GasCalibrationCreated $event)
    {
        $event->device->update(['gas_method' => 1]);
    }
}
