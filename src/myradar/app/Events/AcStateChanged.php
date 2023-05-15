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
use Carbon\Carbon;

class AcStateChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Device
     */
    public $device;

    /**
     * @var boolean
     */
    public $status;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Device $device, $status)
    {
        $this->device = $device;
        $this->status = boolval($status);
    }

    public function title()
    {
        return "Alert for car: {$this->device->car->reg_no}";
    }

    public function body()
    {
        $label = $this->status ? 'ON' : 'OFF';
        $time = Carbon::now()->format('g:i A');
        return "AC was {$label} at {$time}";
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
