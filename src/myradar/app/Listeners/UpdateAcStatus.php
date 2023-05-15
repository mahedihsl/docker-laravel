<?php

namespace App\Listeners;

use App\Events\AcStateChanged;
use App\Events\EngineStatusChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateAcStatus
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
        
        if ($event->device->car->new_service === 1) {
            if ($event->status == 0 && $event->device->ns_state == 1) {
                $event->device->update([ 'ns_state' => 0 ]);
                event(new AcStateChanged($event->device, 0));
            }
        }
    }
}
