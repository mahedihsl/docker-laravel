<?php

namespace App\Listeners;

use App\Events\AccountStatusChanged;
use App\Service\SmsService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendAccountStatusSms
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
     * @param  AccountStatusChanged  $event
     * @return void
     */
    public function handle(AccountStatusChanged $event)
    {
        if ( ! $event->user->isEnabled()) {
            $this->service->send($event->user->phone, $event->body(), 'acc_status');
        }
    }
}
