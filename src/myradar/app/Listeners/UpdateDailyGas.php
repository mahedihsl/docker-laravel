<?php

namespace App\Listeners;

use App\Events\GasReceived;
use App\Contract\Repositories\DailyGasRepository;
use App\Criteria\DeviceIdCriteria;
use App\Criteria\ExactDateCriteria;
use App\Service\Calibration\CalibrationService;
use App\Entities\Device;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;

class UpdateDailyGas
{
    /**
     * @var DailyGasRepository
     */
    private $repository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->repository = resolve(DailyGasRepository::class);
    }

    /**
     * Handle the event.
     *
     * @param  GasReceived  $event
     * @return void
     */
    public function handle(GasReceived $event)
    {
        $meter = $event->device->meter;
        if ($meter->get('gas')->count() < config('car.meter.gas.count')) {
            return;
        }

        $record = $this->repository->skipPresenter()
                        ->pushCriteria(new DeviceIdCriteria($event->device->id))
                        ->pushCriteria(new ExactDateCriteria(Carbon::today()))
                        ->first();

        $service = resolve(CalibrationService::class);
        $avg = floor($meter->get('gas')->avg());

        if ( ! is_null($record)) {
            $interval = config('car.meter.gas.interval');
            if ($record->updated_at->diffInMinutes(Carbon::now()) >= $interval) {
                $record->update([ 'value' => $service->gas($event->device, $avg) ]);
            }
        } else {
            $this->repository->create([
                'value' => $service->gas($event->device, $avg),
                'device_id' => $event->device->id,
                'when' => Carbon::today(),
            ]);
        }
    }

}
