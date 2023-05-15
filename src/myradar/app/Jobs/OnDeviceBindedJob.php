<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Entities\Car;
use App\Entities\Device;
use App\Events\DeviceBinded;

class OnDeviceBindedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	private $car_id;
	private $device_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($device_id, $car_id)
    {
        $this->car_id = $car_id;
		$this->device_id = $device_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		$car = Car::find($this->car_id);
		$device = Device::find($this->device_id);
		event(new DeviceBinded($device, $car));
    }
}
