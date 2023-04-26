<?php

namespace App\Service\Log;
use App\Entities\Device;
use Carbon\Carbon;

abstract class Log
{
    /**
     * @var Device
     */
    private $device;

    function __construct($carId)
    {
        $this->device = Device::where('car_id', $carId)->first();

        if (is_null($this->device)) {
            throw new Exception("No Device Found for this Car");

        }
    }

    protected function getDevice() {
        return $this->device;
    }

    abstract public function status(Carbon $date);
}
