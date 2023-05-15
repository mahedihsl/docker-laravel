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
use App\Entities\Fence;


class FenceEnterExit
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var User
     */
    public $device;

    /**
     * @var Fence
     */
    public $fence_status_array;

    /**
     * Create a new event instance.
     *
     * @return void
     */
     public function __construct(Device $device, array $fence_status_array)
     {
         $this->device = $device;

         $this->fence_status_array = $fence_status_array;
     }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
      //  return new PrivateChannel('channel-name');
    }
}
