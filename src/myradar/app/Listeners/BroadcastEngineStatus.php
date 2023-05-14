<?php

namespace App\Listeners;

use App\Events\EngineStatusChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Vinkla\Pusher\Facades\Pusher;

class BroadcastEngineStatus
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
     * @param  EngineStatusChanged  $event
     * @return void
     */
    public function handle(EngineStatusChanged $event)
    {
        if (is_null($event->device->car)) return;

        $user_ids = $event->device->car->shared_with; //car shared with users
        array_push($user_ids, $event->device->user_id);//actual user

        foreach ($user_ids as $key => $user_id) {
          Pusher::trigger('map-channel-' . $user_id, 'new-event', [
              'type' => $event->getType(),
              'data' => [
                  'status'    => $event->status,
                  'time'      => time(),
                  'device_id' => $event->device->id,
              ]
          ]);
        }
    }
}
