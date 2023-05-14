<?php

namespace App\Listeners;

use App\Events\PaymentReceived;
use App\Service\Microservice\SmsMicroservice;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPaymentAcknowledgeSms
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
        $service = new SmsMicroservice();
        $service->sendRaw($event->payment->user->phone, 'payment_ack', [
            'amount' => $event->payment->amount,
            'reg_no' => $event->payment->car->reg_no,
            'month_from' => $event->payment->months[0],
            'month_count' => sizeof($event->payment->months),
        ]);
    }
}
