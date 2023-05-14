<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Entities\Complain;

class ComplainClosed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $complain;
    public function __construct(Complain $complain)
    {
        $this->complain = $complain;
    }

    public function title()
    {
        return 'Complain Closed';
    }

    public function body()
    {
        return "Dear myRADAR Customer,\nFor car ".$this->complain->car->reg_no."\nYour complain with token number: ".$this->complain->token." has been solved.";
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
