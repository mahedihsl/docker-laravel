<?php

namespace App\Listeners;

use App\Events\FuelReceived;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Vinkla\Pusher\Facades\Pusher;

class NotifyUserAboutFuel
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
     * @param  FuelReceived  $event
     * @return void
     */
    public function handle(FuelReceived $event)
    {
        // Pusher::trigger('map-channel-' . $event->device->user_id, 'fuel-event', [
        //     'message' => [
        //         'fuel_status' => $event->fuel->value,
        //     ]
        // ]);
    }
}
