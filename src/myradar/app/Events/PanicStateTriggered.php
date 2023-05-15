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

class PanicStateTriggered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Device
     */
    public $device;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Device $device)
    {
        $this->device = $device;
    }

    public function title()
    {
        return "Alert for car: {$this->device->car->reg_no}";
    }

    public function body()
    {
        $time = Carbon::now()->format('g:i A');
        return "Emergency button pressed at {$time}";
    }

    public function deliverable() {
        $disabledDevices = [82422, 46131, 63488];
        if (in_array($this->device->com_id, $disabledDevices)) {
            return false;
        }
        return true;
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
