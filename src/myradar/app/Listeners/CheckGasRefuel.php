<?php

namespace App\Listeners;

use App\Events\GasReceived;
use App\Events\GasRefueled;
use App\Service\Refuel\DetectGasRefuel;
use App\Jobs\PushNotificationJob;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckGasRefuel
{
    /**
     * @var DetectGasRefuel
     */
    private $service;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->service = new DetectGasRefuel();
    }

    /**
     * Handle the event.
     *
     * @param  GasReceived  $event
     * @return void
     */
    public function handle(GasReceived $event)
    {
        $this->service->setType($event->device->car->meta_data['cng_type']);

        $samples = $this->dataset($event->device);

        if ($samples->count() == $this->service->sampleCount()) {
            if ($this->service->check($samples) === TRUE) {
                event(new GasRefueled($event->device, $this->service->range()));
            }
        }
    }

    private function dataset($device)
    {
        $gasData = $device->meter->get('gas');
        $gasData = $gasData->reverse()->values();

        $samples = $gasData->splice(1, $this->service->sampleCount());
        return $samples->reverse()->values();
    }
}
