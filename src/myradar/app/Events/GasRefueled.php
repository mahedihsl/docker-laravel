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
use App\Service\PackageService;
use App\Util\GasPriceFactor;
use Carbon\Carbon;

class GasRefueled
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Device
     */
    public $device;

    /**
     * @var integer
     */
    public $magnitude;
    public $peakval;

    private $title = null;
    private $body = null;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Device $device, $range)
    {
        $this->device = $device;
        $this->magnitude = $range[0] - $range[1];
        $this->peakval = $range[0];
    }

    public function isPublic()
    {
        $package = $this->device->car->package;
        $subscribed = $package == PackageService::CAR_PRO_1
                        || $package == PackageService::CAR_PRO_2;
        return $subscribed;
    }

    public function isDeliverable(){
      $factor = $this->device->car->meta_data->get('gas_factor');

      return $factor['status'] || $factor['event_status'];
    }

    public function title()
    {
        if($this->title == null){
          $this->title = "Alert for car: {$this->device->car->reg_no}";
        }

        return $this->title;
    }

    public function body()
    {
        if($this->body == null){
          $time = Carbon::now()->format('g:i A');
          $factor = $this->device->car->meta_data->get('gas_factor');
          $tunefactor = $this->device->car->meta_data->get('gas_tune_factor');

          $phone = '+880 1907888839';
          $this->body = "Your car has taken gas at {$time}.\nTo know your gas amount please call {$phone}";

          if ($factor['status']) {
              // $price = $this->magnitude * $factor['value'];
              $tempmagnitude = abs($this->magnitude);
              $price = $tempmagnitude * GasPriceFactor::getFactor($tempmagnitude, $factor['data']);

              $price=$price * GasPriceFactor::getTuneFactor($this->peakval, $tunefactor);

              $price = round($price);
              $this->body = "Your car has taken gas of {$price} Taka at {$time}";
          }

        }

        return $this->body;
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
