<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Collection;

class ExternalDeviceDataReceived
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

	public $device;

	/**
	 *
	 * @param Collection
	 **/
	public $data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($device, $data)
    {
		$this->device = $device;
		$this->data = collect($data);
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
