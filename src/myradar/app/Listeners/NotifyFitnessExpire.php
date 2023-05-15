<?php

namespace App\Listeners;

use App\Events\FitnessDateExpire;
use App\Service\NotificationService;
use App\Jobs\PushNotificationJob;
use App\Service\Microservice\PushMicroservice;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;

class NotifyFitnessExpire
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
     * @param  FitnessDateExpire  $event
     * @return void
     */
    public function handle(FitnessDateExpire $event)
    {
        $settings = $event->car->user->settings;

        if (is_null($settings) || $settings->noti_date) {

            $data = collect([
                'title' => '',
                'body' => "Your car fitness date will expire in {$event->days} days",
                'type' => NotificationService::$TYPE_DATE,
            ]);

            $service = new PushMicroservice();
            $service->send($event->car->user_id, $data);
        }
    }
}
