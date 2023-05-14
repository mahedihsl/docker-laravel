<?php

namespace App\Service\Calibration;

use App\Entities\Device;


class ComplexCalibrator extends BaseCalibrator
{

    function __construct(Device $device)
    {
        parent::__construct($device);
    }

    public function fuel($value)
    {
        # code...
    }

    public function gas($value)
    {
        # code...
    }

}
