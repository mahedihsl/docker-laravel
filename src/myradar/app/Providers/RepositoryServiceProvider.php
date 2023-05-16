<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Contract\Repositories\UserRepository::class, \App\Repositories\Eloquent\UserRepositoryEloquent::class);
        $this->app->bind(\App\Contract\Repositories\CarRepository::class, \App\Repositories\Eloquent\CarRepositoryEloquent::class);
        $this->app->bind(\App\Contract\Repositories\DeviceRepository::class, \App\Repositories\Eloquent\DeviceRepositoryEloquent::class);
        $this->app->bind(\App\Contract\Repositories\DistrictRepository::class, \App\Repositories\Eloquent\DistrictRepositoryEloquent::class);
        $this->app->bind(\App\Contract\Repositories\ThanaRepository::class, \App\Repositories\Eloquent\ThanaRepositoryEloquent::class);
        $this->app->bind(\App\Contract\Repositories\FenceRepository::class, \App\Repositories\Eloquent\FenceRepositoryEloquent::class);
        $this->app->bind(\App\Contract\Repositories\FenceLogRepository::class, \App\Repositories\Eloquent\FenceLogRepositoryEloquent::class);
        $this->app->bind(\App\Contract\Repositories\PoiRepository::class, \App\Repositories\Eloquent\PoiRepositoryEloquent::class);
        $this->app->bind(\App\Contract\Repositories\HealthRepository::class, \App\Repositories\Eloquent\HealthRepositoryEloquent::class);
        $this->app->bind(\App\Contract\Repositories\PaymentRepository::class, \App\Repositories\Eloquent\PaymentRepositoryEloquent::class);
        $this->app->bind(\App\Contract\Repositories\MileageRepository::class, \App\Repositories\Eloquent\MileageRepositoryEloquent::class);
        $this->app->bind(\App\Contract\Repositories\PositionRepository::class, \App\Repositories\Eloquent\PositionRepositoryEloquent::class);
        $this->app->bind(\App\Contract\Repositories\FuelHistoryRepository::class, \App\Repositories\Eloquent\FuelHistoryRepositoryEloquent::class);
        $this->app->bind(\App\Contract\Repositories\GasHistoryRepository::class, \App\Repositories\Eloquent\GasHistoryRepositoryEloquent::class);
        $this->app->bind(\App\Contract\Repositories\DrivingHourRepository::class, \App\Repositories\Eloquent\DrivingHourRepositoryEloquent::class);
        $this->app->bind(\App\Contract\Repositories\DutyHourRepository::class, \App\Repositories\Eloquent\DutyHourRepositoryEloquent::class);
        $this->app->bind(\App\Contract\Repositories\SettingRepository::class, \App\Repositories\Eloquent\SettingRepositoryEloquent::class);
        $this->app->bind(\App\Contract\Repositories\DailyFuelRepository::class, \App\Repositories\Eloquent\DailyFuelRepositoryEloquent::class);
        $this->app->bind(\App\Contract\Repositories\DailyGasRepository::class, \App\Repositories\Eloquent\DailyGasRepositoryEloquent::class);
        $this->app->bind(\App\Contract\Repositories\FuelCalibrationRepository::class, \App\Repositories\Eloquent\FuelCalibrationRepositoryEloquent::class);
        $this->app->bind(\App\Contract\Repositories\GasCalibrationRepository::class, \App\Repositories\Eloquent\GasCalibrationRepositoryEloquent::class);
        $this->app->bind(\App\Contract\Repositories\RefuelFeedRepository::class, \App\Repositories\Eloquent\RefuelFeedRepositoryEloquent::class);
        $this->app->bind(\App\Contract\Repositories\MessageRepository::class, \App\Repositories\Eloquent\MessageRepositoryEloquent::class);
        $this->app->bind(\App\Contract\Repositories\ActivationRepository::class, \App\Repositories\Eloquent\ActivationRepositoryEloquent::class);
        $this->app->bind(\App\Contract\Repositories\DriverRepository::class, \App\Repositories\Eloquent\DriverRepositoryEloquent::class);
        $this->app->bind(\App\Contract\Repositories\EventRepository::class, \App\Repositories\Eloquent\EventRepositoryEloquent::class);
        $this->app->bind(\App\Contract\Repositories\EmployeeRepository::class, \App\Repositories\Eloquent\EmployeeRepositoryEloquent::class);
        $this->app->bind(\App\Contract\Repositories\AssignmentRepository::class, \App\Repositories\Eloquent\AssignmentRepositoryEloquent::class);
        $this->app->bind(\App\Contract\Repositories\ZoneRepository::class, \App\Repositories\Eloquent\ZoneRepositoryEloquent::class);
        $this->app->bind(\App\Contract\Repositories\PerformanceRepository::class, \App\Repositories\Eloquent\PerformanceRepositoryEloquent::class);
        $this->app->bind(\App\Contract\Repositories\TripRepository::class, \App\Repositories\Eloquent\TripRepositoryEloquent::class);
        $this->app->bind(\App\Contract\Repositories\PromotionRepository::class, \App\Repositories\Eloquent\PromotionRepositoryEloquent::class);
        $this->app->bind(\App\Contract\Repositories\PromoCodeRepository::class, \App\Repositories\Eloquent\PromoCodeRepositoryEloquent::class);
        $this->app->bind(\App\Contract\Repositories\ComplainRepository::class, \App\Repositories\Eloquent\ComplainRepositoryEloquent::class);
        $this->app->bind(\App\Contract\Repositories\ActivityRepository::class, \App\Repositories\Eloquent\ActivityRepositoryEloquent::class);
        $this->app->bind(\App\Contract\Repositories\NoticeRepository::class, \App\Repositories\Eloquent\NoticeRepositoryEloquent::class);
        $this->app->bind(\App\Contract\Repositories\GeofenceRepository::class, \App\Repositories\Eloquent\GeofenceRepositoryEloquent::class);
        //:end-bindings:
    }
}
