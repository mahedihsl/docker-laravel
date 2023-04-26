<?php

namespace App\Service\Calibration;

use App\Entities\Car;
use App\Entities\Device;


abstract class BaseCalibrator {

    /**
     * @var Device
     */
    protected $device;

    public function __construct(Device $device)
    {
        $this->device = $device;
    }

    protected function getDevice()
    {
        return $this->device;
    }

    protected function isCngTypeA()
    {
        return $this->getCngType() == Car::CNG_TYPE_A;
    }

    protected function isCngTypeB()
    {
        return $this->getCngType() == Car::CNG_TYPE_B;
    }

    private function getCngType()
    {
        return $this->device->car->meta_data['cng_type'];
    }

    protected function getFuelGroup() {
        return $this->device->car->fule_group;
    }

    abstract public function fuel($value);

    abstract public function gas($value);
}
