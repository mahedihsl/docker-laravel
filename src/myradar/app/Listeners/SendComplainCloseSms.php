<?php

namespace App\Listeners;

use App\Events\ComplainClosed;
use App\Service\SmsService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendComplainCloseSms
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
     * @param  ComplainClosed  $event
     * @return void
     */
    public function handle(ComplainClosed $event)
    {
      $service = new SmsService();
      $service->send($event->complain->car->user->phone, $event->body(), 'complain_cls');
    }
}
