<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Entities\Event;
use App\Entities\Assignment;
use App\Entities\GasCalibration;
use App\Entities\FuelCalibration;
use App\Observers\AssignmentObserver;
use App\Observers\EventObserver;
use App\Observers\GasCalibrationObserver;
use App\Observers\FuelCalibrationObserver;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        FuelCalibration::observe(FuelCalibrationObserver::class);
        GasCalibration::observe(GasCalibrationObserver::class);
        Assignment::observe(AssignmentObserver::class);
        Event::observe(EventObserver::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
