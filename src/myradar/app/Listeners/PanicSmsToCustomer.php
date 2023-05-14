<?php

namespace App\Listeners;

use App\Events\PanicStateTriggered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PanicSmsToCustomer
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
     * @param  PanicStateTriggered  $event
     * @return void
     */
    public function handle(PanicStateTriggered $event)
    {
        //
    }
}
