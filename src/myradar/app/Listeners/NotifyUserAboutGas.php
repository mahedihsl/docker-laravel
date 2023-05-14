<?php

namespace App\Listeners;

use App\Events\GasReceived;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Vinkla\Pusher\Facades\Pusher;

class NotifyUserAboutGas
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
     * @param  GasReceived  $event
     * @return void
     */
    public function handle(GasReceived $event)
    {
        // Pusher::trigger('map-channel-' . $event->device->user_id, 'gas-event', [
        //     'message' => [
        //         'gas_status' => $event->gas->value,
        //     ]
        // ]);
    }
}
