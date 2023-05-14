<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SpeedLimitExceeded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    /**
     * @var Fence
     */
    public $speed;
    public $limit;
    public $flag;

    /**
     * Create a new event instance.
     *
     * @return void
     */
     public function __construct($user,$speed,$limit,bool $flag)
     {
         $this->user = $user;
         $this->speed = $speed;
         $this->limit = $limit;
         $this->flag = $flag; //0 or 1
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
