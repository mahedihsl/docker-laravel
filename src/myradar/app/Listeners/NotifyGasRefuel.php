<?php

namespace App\Listeners;

use App\Events\GasRefueled;
use App\Jobs\PushNotificationJob;
use App\Service\SmsService;
use App\Service\NotificationService;
use App\Contract\Repositories\EventRepository;
use App\Entities\Event;
use App\Service\Microservice\PushMicroservice;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class NotifyGasRefuel
{
    /**
     * @var EventRepository
     */
    private $repository;

    /**
     * @var SmsService
     */
    private $service;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(EventRepository $repository)
    {
        $this->repository = $repository;
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
        $package = $event->device->car->package;
        $private_event = $package != 1 && $package != 4;

        $data = $this->payload($event->device, $event->magnitude);
        $model = $this->repository->save($event->device, $data, Event::TYPE_REFUEL);

        $model->update([
            'meta' => [
                'magnitude' => $event->magnitude,
            ]
        ]);

        $service = new PushMicroservice();
        $service->send($event->device->user_id, $data);

        $this->sendSms($event->device, $event->magnitude);
    }

    public function payload($device, $magnitude)
    {
        return collect([
            'title' => $this->title($device),
            'body'  => $this->body($device, $magnitude),
            'type'  => NotificationService::$TYPE_GAS,
        ]);
    }

    public function sendSms($device, $magnitude)
    {
        $content = $this->title($device) . ".\n" . $this->body($device, $magnitude) . ".";
        $this->service->send($device->user->phone, $content);
    }

    public function title($device)
    {
        return "Alert for car: {$device->car->reg_no}";
    }

    public function body($device, $magnitude)
    {
        $factor = $device->car->meta_data->get('gas_factor');
        if ($factor['status']) {
            $price = $magnitude * $factor['value'];
            return "Your car has taken gas of {$price} Taka";
        }

        $phone = '+880 1907888839';
        $time = Carbon::now()->format('g:i A');

        return "Your car has taken gas at {$time}.\nTo know your gas amount please call {$phone}";
    }
}
