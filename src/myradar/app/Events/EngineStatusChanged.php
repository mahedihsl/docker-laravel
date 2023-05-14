<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Entities\Event;
use App\Entities\Device;

class EngineStatusChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Device
     */
    public $device;

    public $status;

    public $silent;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Device $device, $status, $silent = FALSE)
    {
        $this->device = $device;
        $this->status = $status;
        $this->silent = $silent;
    }

    public function getType()
    {
        return $this->status ? Event::TYPE_ON : Event::TYPE_OFF;
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
