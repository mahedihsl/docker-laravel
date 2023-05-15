<?php

namespace App\Listeners;

use App\Events\GeoFenceEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GeoFenceListener
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
     * @param  GeoFenceEvent  $event
     * @return void
     */
    public function handle(GeoFenceEvent $event)
    {
        //
    }
}
