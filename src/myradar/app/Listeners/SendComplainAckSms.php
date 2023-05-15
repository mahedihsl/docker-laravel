<?php

namespace App\Listeners;

use App\Events\ComplainCreated;
use App\Service\SmsService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendComplainAckSms
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
     * @param  ComplainCreated  $event
     * @return void
     */
    public function handle(ComplainCreated $event)
    {
      $service = new SmsService();
      $service->send($event->complain->car->user->phone, $event->body(), 'complain_ack');
    }
}
