<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Entities\Car;

class CarCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Car
     */
    public $car;

    /**
     * @var integer
     */
    public $code;

    /**
     * @var integer
     */
    public $promo;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Car $car, $code, $promo)
    {
        $this->car = $car;
        $this->code = intval($code);
        $this->promo = $promo;
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
