<?php

namespace App\Listeners;

use App\Events\FuelReceived;
use App\Events\FuelRefueled;
use App\Service\Refuel\DetectFuelRefuel;
use App\Service\Microservice\FuelMicroservice;

class CheckFuelRefuel
{

    /**
     * @var DetectFuelRefuel
     */
    private $service;

    private $fuelService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->service = new DetectFuelRefuel();
        $this->fuelService = new FuelMicroservice();
    }

    /**
     * Handle the event.
     *
     * @param  FuelReceived  $event
     * @return void
     */
    public function handle(FuelReceived $event)
    {
        try {
          $batch = $event->device->meter->get('newFuel');
          $minBatchSize = config('car.refuelByFiltering.fuel.minBatchSize');

          if($batch->count() == $minBatchSize)
          {
            $value = $this->service->check($batch);
            if($value == -1){
              $event->device->update([ 'meter.new_fuel' => [] ]);
            } else {
              $prevFuel = $event->device->meta->get('prevFuel');

              $threshold = config('car.refuelByFiltering.fuel.threshold');
              if (!is_null($prevFuel) && abs($value-$prevFuel) > $threshold) {
                event(new FuelRefueled($event->device, [$prevFuel, $value]));
              }
              $event->device->update(["meta.prev_fuel" =>  $value ]);
              
              $this->fuelService->storeAvarage($value, $event->device->id);
            }
          }
        } catch (\Exception $e) {}
    }
}
