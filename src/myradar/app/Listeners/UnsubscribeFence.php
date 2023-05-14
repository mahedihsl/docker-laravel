<?php

namespace App\Listeners;

use App\Events\FenceDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UnsubscribeFence
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
        if (in_array($event->fence->id, $event->car->fence_ids ?: [])) {
            $event->car->fences()->detach($event->fence->id);
        }
    }
}
