<?php

namespace App\Listeners;

use App\Events\FuelReceived;
use App\Contract\Repositories\DailyFuelRepository;
use App\Criteria\DeviceIdCriteria;
use App\Criteria\ExactDateCriteria;
use App\Entities\Device;
use App\Entities\FuelHistory;
use App\Service\Calibration\CalibrationService;
use App\Consumer\FuelConsumer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;

class UpdateDailyFuel
{
    /**
     * @var DailyFuelRepository
     */
    private $repository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->repository = resolve(DailyFuelRepository::class);
    }

    /**
     * Handle the event.
     *
     * @param  FuelReceived  $event
     * @return void
     */
    public function handle(FuelReceived $event)
    {
        $meter = $event->device->meter;
        if ($meter->get('fuel')->count() < FuelConsumer::SAMPLE_COUNT) {
            return;
        }

        $record = $this->repository->skipPresenter()
                        ->pushCriteria(new DeviceIdCriteria($event->device->id))
                        ->pushCriteria(new ExactDateCriteria(Carbon::today()))
                        ->first();

        $service = resolve(CalibrationService::class);
        $avg = $event->device->meta->get('prevFuel');
        if(is_null($avg)){
          $avg = floor($meter->get('fuel')->avg());
        }
        $fuelPercentage = $service->fuel($event->device, $avg);
        if ( ! is_null($record)) {
            $interval = config('car.meter.fuel.interval');
            $currMin = is_null($record->min) ? $record->value : $record->min;
            $currMax = is_null($record->max) ? $record->value : $record->max;
            if ($record->updated_at->diffInMinutes(Carbon::now()) > $interval) {
                $record->update([
                    'value' => $fuelPercentage,
                    'min' => min($currMin, $fuelPercentage),
                    'max' => max($currMax, $fuelPercentage),
                ]);
            }
        } else {
            $this->repository->create([
                'value' => $fuelPercentage,
                'min' => $fuelPercentage,
                'max' => $fuelPercentage,
                'device_id' => $event->device->id,
                'when' => Carbon::today(),
            ]);
        }
    }

}
