<?php

namespace App\Listeners;

use App\Events\GasRefueled;
use App\Service\SmsService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendGasRefuelSms
{
    /**
     * @var SmsService
     */
    private $service;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->service = new SmsService();
    }

    /**
     * Handle the event.
     *
     * @param  GasRefueled  $event
     * @return void
     */
    public function handle(GasRefueled $event)
    {
        // echo "inside handle method\n";
        if ($event->isPublic() && $event->isDeliverable()) {
            // echo "sending sms\n";
            $content = $event->title() . ".\n" . $event->body() . ".";
            $res = $this->service->send($event->device->user->phone, $content, 'gas_refuel');
            //echo "sms response: " . $res . "\n";
        }
    }
}
