<?php

namespace App\Listeners;

use App\Events\GasStatus;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\App;
use Vinkla\Pusher\Facades\Pusher;
use App\Entities\Device;
class getUpdatedGasStatus
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
     * @param  GasStatus  $event
     * @return void
     */
    public function handle(GasStatus $event)
    {
      $data = json_decode($event->gas,true);
      $device_id = $data['device_id'];
      $user = Device::find($device_id)->user->id;
      $gas_status = $data['gas_status'];
      Pusher::trigger('map-channel-'.$user, 'gas-event', ['message' => ['gas_status'=>$gas_status]]);
    }
}
