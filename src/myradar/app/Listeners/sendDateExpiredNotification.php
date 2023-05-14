<?php

namespace App\Listeners;

use App\Events\DateExpirationEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Entities\User;
use App\Entities\Car;
use App\Http\Controllers\PushNotification\PushNotificationController;
use Illuminate\Support\Facades\Log;

class sendDateExpiredNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

      $this->PushNotification = new PushNotificationController();

    }

    /**
     * Handle the event.
     *
     * @param  DateExpirationEvent  $event
     * @return void
     */
    public function handle(DateExpirationEvent $event)
    {

      echo ":hah aha";
      Log::info("hello mama");
      

    }
}
