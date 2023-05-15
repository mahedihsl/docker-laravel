<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Collection;
use App\Entities\Device;
use App\Generator\ServiceConsumerGenerator;

class ServiceStringReceived
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Device
     */
    public $device;

    /**
     * @var Collection
     */
    public $count;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Device $device, Collection $count)
    {
        $this->device = $device;
        $this->count = $count;
    }

    public function positionCount()
    {
        return $this->getDataCount(ServiceConsumerGenerator::KEY_LATLNG);
    }

    public function gasCount()
    {
        return $this->getDataCount(ServiceConsumerGenerator::KEY_GAS);
    }

    public function fuelCount()
    {
        return $this->getDataCount(ServiceConsumerGenerator::KEY_FUEL);
    }

    public function getDataCount($key)
    {
        return ! $this->device->engine_status ? 0 : $this->count->get($key, 0);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
