<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\Entities\Device;

class DeviceBalanceReceived
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Device
     */
    public $device;

    public $balance;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Device $device, $balance)
    {
        $this->device = $device;
        $this->balance = $balance;
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
