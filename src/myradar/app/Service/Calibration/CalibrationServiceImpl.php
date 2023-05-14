<?php

namespace App\Service\Calibration;

use App\Entities\Device;
use App\Service\Calibration\CalibrationService;


class CalibrationServiceImpl implements CalibrationService
{
    function __construct()
    {
        # code...
    }

    public function fuel(Device $device, $value)
    {
        return $this->getCalibrator($device, $device->fuel_method)->fuel($value);
    }

    public function gas(Device $device, $value)
    {
        return $this->getCalibrator($device, $device->gas_method)->gas($value);
    }

    private function getCalibrator(Device $device, $method)
    {
        if ($method === 0) {
            return new SimpleCalibrator($device);
        }

        if ($method === 1) {
            return new CustomCalibrator($device);
        }

        return new ComplexCalibrator($device);
    }
}
