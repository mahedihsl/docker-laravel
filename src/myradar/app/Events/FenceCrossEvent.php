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
use App\Entities\Car;
use App\Entities\Fence;
use Carbon\Carbon;

class FenceCrossEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Device
     */
    public $device;

    /**
     * @var Fence
     */
    public $fence;

    public $flag;

    private $carType;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Device $device, Fence $fence, $flag)
    {
        $this->device = $device;
        $this->fence = $fence;
        $this->flag = $flag;
        $this->carType = $device->car->type;
    }

    public function isTypeBus()
    {
        return $this->carType == Car::TYPE_BUS;
    }

    public function getTitle()
    {
        return 'Alert for car: ' . $this->device->car->reg_no;
    }

    public function getBody()
    {
        $time = Carbon::now()->format('g:i A');
        $status = $this->flag ? 'arrived' : 'left';
        return "Your Car {$status} {$this->fence->name} at {$time}";
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
