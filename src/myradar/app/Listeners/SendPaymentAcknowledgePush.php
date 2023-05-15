<?php

namespace App\Listeners;

use App\Events\PaymentReceived;
use App\Jobs\PushNotificationJob;
use App\Service\Microservice\PushMicroservice;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPaymentAcknowledgePush
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
     * @param  PaymentReceived  $event
     * @return void
     */
    public function handle(PaymentReceived $event)
    {
        $data = collect([
            'title' => $event->title(),
            'body' => $event->body(),
        ]);

        $service = new PushMicroservice();
        $service->send($event->payment->user_id, $data);
    }
}
