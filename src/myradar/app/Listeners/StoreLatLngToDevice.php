<?php

namespace App\Listeners;

use App\Events\LatLngReceived;
use App\Transformers\PositionTransformer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Service\DirectionService;
use App\Entities\Device;
use App\Entities\Position;
use Carbon\Carbon;

class StoreLatLngToDevice
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
     * @param  LatLngReceived  $event
     * @return void
     */
    public function handle(LatLngReceived $event)
    {
          $transformer = new PositionTransformer();
          $event->device->update([
              'meta.pos' => $transformer->transform($event->position)
          ]);

          $lastMilPos = $this->getLastMilPos($event->device);

          if(is_null($lastMilPos)){
            $event->device->update([
                'meta.mil_pos' => $transformer->transform($event->position)
            ]);
          }
          else{
            $service = new DirectionService();
            $distance = $service->distance($lastMilPos['lat'], $lastMilPos['lng'], $event->position->lat, $event->position->lng);
            $threshold = config('car.mileage.position.diff');

            if($distance > $threshold){
              $event->device->update([
                  'meta.mil_pos' => $transformer->transform($event->position)
              ]);
            }
          }
    }

    public function getLastMilPos(Device $device)
    {
        return $device->meta['mil_pos'];
    }
}
