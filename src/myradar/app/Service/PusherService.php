<?php

namespace App\Service;

use Vinkla\Pusher\Facades\Pusher;

class PusherService
{

    function __construct()
    {
        
        # code...
    }

    public function onEngineOff($device)
    {
        $user = $device->user;
        Pusher::trigger('map-channel-'.$user->id, 'engine-off-event', [
            'message' => [
                    'engine_status' => $device->engine_status,
                    'lock_status' => $device->lock_status,
                ]
            ]
        );
    }

    public function onEngineOn($device)
    {
        # code...
    }
}
