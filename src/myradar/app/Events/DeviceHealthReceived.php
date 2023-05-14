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

class DeviceHealthReceived
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Device
     */
    public $device;

    /**
     * @var Collection
     */
    private $data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Device $device, Collection $data)
    {
        $this->device = $device;
        $this->data = $data;
    }

    public function isResetEvent()
    {
        return intval($this->data->get('count_loop')) == 1;
    }

    /**
     * @return string imei number or empty string
     */
    public function getImei()
    {
        return $this->data->get('imei', '');
    }

    /**
     * @return boolean whether the imei number is present or not
     */
    public function hasImei()
    {
        return boolval($this->getImei());
    }

    public function getDeviceVersion()
    {
        return $this->data->get('version', '');
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
