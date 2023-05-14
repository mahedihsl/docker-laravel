<?php

namespace App\Listeners;

use App\Events\GasReceived;
use App\Events\GasRefueledByFiltering;
use App\Service\Refuel\DetectGasRefuelByFiltering;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckGasRefuelByFiltering
{

    /**
     * @var DetectGasRefuelByFiltering
     */
    private $service;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->service = new DetectGasRefuelByFiltering();
    }

    /**
     * Handle the event.
     *
     * @param  GasReceived  $event
     * @return void
     */
    public function handle(GasReceived $event)
    {
      try {
        $this->service->setType($event->device->car->meta_data['cng_type']);
        $cngType = $event->device->car->meta_data['cng_type'];
        $batch = $event->device->meter->get('newGas');
        $minBatchSize = config('car.refuelByFiltering.gas.minBatchSize');
        if($cngType == 2){
          $minBatchSize = config('car.refuelByFiltering.gas.minBatchSize2');
        }

        if($batch->count() == $minBatchSize)
        {
          $value = $this->service->check($batch);

          if($value == -1){
            $event->device->update([ 'meter.new_gas' => [] ]);
          }
          else {
            $prevGas = $event->device->meta->get('prevGas');

            if($cngType ==1){
              $threshold = config('car.refuelByFiltering.gas.threshold');
              if (!is_null($prevGas) && $prevGas-$value > $threshold) {
                event(new GasRefueledByFiltering($event->device, [$prevGas, $value]));
              }
            }
            else if($cngType ==2){
              $threshold = config('car.refuelByFiltering.gas.threshold2');
              if (!is_null($prevGas) && $prevGas-$value < $threshold) {
                event(new GasRefueledByFiltering($event->device, [$prevGas, $value]));
              }
            }


            $event->device->update(["meta.prev_gas" =>  $value ]);

          }
        }
      } catch (\Exception $e) {}

    }

}
