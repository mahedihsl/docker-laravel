<?php

namespace App\Listeners;

use App\Events\FuelRefueled;
use App\Service\SmsService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendFuelRefuelSms
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
        if ($event->isPublic() && $event->isDeliverable()) {
            $content = $event->title() . ".\n" . $event->body() . ".";
            $this->service->send($event->device->user->phone, $content, 'fuel_refuel');
        }
    }
}
