<?php

namespace App\Listeners;

use App\Events\FenceCrossEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;

class UpdateFenceMetaData
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
     * @param  FenceCrossEvent  $event
     * @return void
     */
    public function handle(FenceCrossEvent $event)
    {
        $props = [
            'meta.fence_id' => $event->flag ? $event->fence->id : null,
        ];

        if ( ! $event->flag) {
            $props['meta.fence_out'] = [
                'id' => $event->fence->id,
                'name' => $event->fence->name,
                'time' => Carbon::now()->timestamp,
            ];
        }

        $event->device->update($props);
    }
}
