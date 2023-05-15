<?php

namespace App\Listeners;

use App\Events\PanicStateTriggered;
use App\Service\SmsService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPanicSms
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
        if ( ! $event->deliverable()) return;
        
        $content = $event->title() . "\n" . $event->body();

        $service = new SmsService();
        $service->send($event->device->user->phone, $content, 'panic');
    }
}
