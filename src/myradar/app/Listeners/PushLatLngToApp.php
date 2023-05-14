<?php

namespace App\Listeners;

use App\Events\LatLngReceived;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Vinkla\Pusher\Facades\Pusher;
use Vinkla\Pusher\PusherFactory;
use Carbon\Carbon;

class PushLatLngToApp
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
        if (is_null($event->device->live_track) ||
         $event->device->live_track->diffInMinutes(Carbon::now()) > 10) {
            return;
        }

        $user_ids = $event->device->car->shared_with; //car shared with users
        array_push($user_ids, $event->device->user_id);//actual user

        foreach ($user_ids as $key => $user_id) {  //show live to all users
            $reply = Pusher::trigger('map-channel-' . $user_id, 'map-event', [
                'message' => [
                    'lat' => strval($event->position->lat),
                    'lng' => strval($event->position->lng),
                    'speed' => floor($event->position->speed),
                    'time' => $event->position->when->timestamp,
                    'device_id' => $event->device->id,
                ]
            ]);

            // Log::info('pushing lat/lng: ', [
            //     'channel' => 'map-channel-' . $user_id,
            //     // 'com_id' => $event->device->com_id,
            //     // 'lat' => $event->position->lat,
            //     // 'lng' => $event->position->lng,
            //     'reply' => $reply,
            // ]);

            try {
                $factory = new PusherFactory();
                $pusher_new = $factory->make(config('pusher.connections.alternative'));
                $pusher_new->trigger('map-channel-' . $user_id, 'map-event', [
                    'message' => [
                        'lat' => strval($event->position->lat),
                        'lng' => strval($event->position->lng),
                        'time' => $event->position->when->timestamp,
                        'device_id' => $event->device->id,
                    ]
                ]);
            } catch (\Exception $e) {

            }

        }
    }
}
