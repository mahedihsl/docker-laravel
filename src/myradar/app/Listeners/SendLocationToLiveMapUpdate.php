<?php

namespace App\Listeners;

use App\Events\getLocation;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\App;
use Vinkla\Pusher\Facades\Pusher;
use App\Entities\User;
use App\Entities\Device;

class SendLocationToLiveMapUpdate
{
    /**
     * Create the event listener.
     *
     * @return void
     */
   protected $location;
   protected $device_id;

     public function __construct()
     {
        //
     }

    /**
     * Handle the event.
     *
     * @param  getLocation  $event
     * @return void
     */
    public function handle(getLocation $event)
    {
      $location = json_decode($event->location,true);

      $device_id = $location['Device'][0];

      $user = Device::where('_id','=',$device_id)->first()->toArray()['user_id'];

      Pusher::trigger('map-channel-'.$user, 'map-event', ['message' => $location]);

      // if()
    	//   {
    	// 	  echo "trig";
    	//   }
    }
}
