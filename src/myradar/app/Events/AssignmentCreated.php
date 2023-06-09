<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Entities\Assignment;

class AssignmentCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Assignment
     */
    public $assignment;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Assignment $model)
    {
        $this->assignment = $model;
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
