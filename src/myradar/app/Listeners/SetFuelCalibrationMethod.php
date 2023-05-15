<?php

namespace App\Listeners;

use App\Events\FuelCalibrationCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SetFuelCalibrationMethod
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
     * @param  FuelCalibrationCreated  $event
     * @return void
     */
    public function handle(FuelCalibrationCreated $event)
    {
        $event->device->update(['fuel_method' => 1]);
    }
}
