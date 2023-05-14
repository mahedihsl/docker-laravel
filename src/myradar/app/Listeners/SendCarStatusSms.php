<?php

namespace App\Listeners;

use App\Events\CarStatusChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendCarStatusSms
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
     * @param  CarStatusChanged  $event
     * @return void
     */
    public function handle(CarStatusChanged $event)
    {
        //
    }
}
