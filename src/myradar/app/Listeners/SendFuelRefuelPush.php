<?php

namespace App\Listeners;

use App\Events\FuelRefueled;
use App\Service\NotificationService;
use App\Jobs\PushNotificationJob;
use App\Service\Microservice\PushMicroservice;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendFuelRefuelPush
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
     * @param  GasRefueled  $event
     * @return void
     */
    public function handle(GasRefueled $event)
    {
        if ($event->isPublic() && $event->isDeliverable()) {
            $data = collect([
                'title' => $event->title(),
                'body'  => $event->body(),
                'type'  => NotificationService::$TYPE_GAS,
            ]);

            $service = new PushMicroservice();
            $service->send($event->device->user_id, $data);
        }
    }
}
