<?php

namespace App\Listeners;

use App\Events\FenceCrossEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Carbon\Carbon;
use App\Service\NotificationService;
use App\Jobs\PushNotificationJob;
use App\Service\Microservice\PushMicroservice;

class FenceCrossListener
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
     * @param  FenceCrossEvent  $event
     * @return void
     */
    public function handle(FenceCrossEvent $event)
    {
        $settings = $event->device->user->settings;
        if ((is_null($settings) || $settings->noti_geofence)) {
            $data = collect([
                'title' => 'Alert for car: ' . $event->device->car->reg_no,
                'body' => $this->getBody($event->fence, $event->flag),
                'type' => NotificationService::$TYPE_FENCE,
            ]);

            $service = new PushMicroservice();
            $service->send($event->device->user_id, $data);
        }
    }

    public function getTitle()
    {
        return "Geofence Alert";
    }

    public function getBody($fence, $flag)
    {
        $time = Carbon::now()->format('g:i A');
        $status = $flag ? 'arrived' : 'left';
        return "Your Car {$status} {$fence->name} at {$time}";
    }
}
