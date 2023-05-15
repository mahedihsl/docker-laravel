<?php

namespace App\Listeners;

use App\Events\FuelStatus;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\App;
use Vinkla\Pusher\Facades\Pusher;
use App\Entities\Device;

class getUpdatedFuelStatus
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    //protected $fuel;
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  FuelGasStatus  $event
     * @return void
     */
    public function handle(FuelStatus $event)
    {

      $data = json_decode($event->fuel,true);
      $device_id = $data['device_id'];
      $user = Device::find($device_id)->user->id;
      $fuel_status = $data['fuel_status'];
      Pusher::trigger('map-channel-'.$user, 'fuel-event', ['message' => ['fuel_status'=>$fuel_status]]);

    }
}
