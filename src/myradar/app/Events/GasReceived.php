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
use App\Entities\GasHistory;
use App\Service\PackageService;

class GasReceived
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Device
     */
    public $device;

    /**
     * @var GasHistory
     */
    public $gas;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Device $device, GasHistory $gas)
    {
        $this->device = $device;
        $this->gas = $gas;
    }

    public function isPublic()
    {
        $package = $this->device->car->package;
        $subscribed = $package == PackageService::CAR_PRO_1
                        || $package == PackageService::CAR_PRO_2;
        return $subscribed;
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
