<?php

namespace App\Listeners;

use App\Events\CarCreated;
use App\Entities\Activation;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MakeActivationKey
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
     * @param  CarCreated  $event
     * @return void
     */
    public function handle(CarCreated $event)
    {
        $count = intval(Activation::where('code', $event->code)->max('serial'));
        $event->car->activation()->create([
            'code' => $event->code,
            'serial' => $count + 1,
        ]);
    }
}
