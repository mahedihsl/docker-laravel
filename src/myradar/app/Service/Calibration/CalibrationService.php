<?php

namespace App\Service\Calibration;

use App\Entities\Device;


interface CalibrationService
{
    public function fuel(Device $device, $value);

    public function gas(Device $device, $value);
}
