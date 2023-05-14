<?php

namespace App\Listeners;

use App\Events\DeviceBinded;
use App\Entities\Event;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;

class HideEventData
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
     * @param  DeviceBinded  $event
     * @return void
     */
    public function handle(DeviceBinded $event)
    {
        Event::where('car_id', $event->car->id)
                ->where('created_at', '<', Carbon::now())
                ->delete();
    }
}
