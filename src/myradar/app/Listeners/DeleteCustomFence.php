<?php

namespace App\Listeners;

use App\Events\FenceDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeleteCustomFence
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
     * @param  FenceDeleted  $event
     * @return void
     */
    public function handle(FenceDeleted $event)
    {
        if ($event->fence->isCustomFence()) {
            if (sizeof($event->fence->car_ids) == 1
                && in_array($event->car->id, $event->fence->car_ids ?: [])) {
                $event->fence->delete();
            }
        }

    }
}
