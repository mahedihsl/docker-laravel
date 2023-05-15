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

class SpeedLimitCrossEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Device
     */
    public $device;

    public $flag;
    public $limit;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Device $device, $limit, $flag)
    {
        $this->device = $device;
        $this->limit = intval($limit);
        $this->flag = boolval($flag);
    }

    public function title()
    {
        return 'Alert for car: ' . $this->device->car->reg_no;
    }

    public function body()
    {
        $status = $this->flag ? 'above' : 'below';
        return "Car is running {$status} {$this->limit} km/h";
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
