<?php

namespace App\Listeners;

use App\Events\CustomerCreated;
use App\Service\SmsService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPasswordSms
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
     * @param  CustomerCreated  $event
     * @return void
     */
    public function handle(CustomerCreated $event)
    {
        $phone = $event->data->get('phone');
        $password = $event->data->get('password');

        $message = 'CONGRATULATIONS!! Welcome to myRADAR family. ';
        $message .= 'Your default password is: ' . $password . "\n";
        $message .= 'Please Log In using link: http://www.myradar.com.bd/login';

        $this->service->send($phone, $message, 'password');
    }
}
