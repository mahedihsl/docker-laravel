<?php

namespace App\Service\Calibration;

use App\Entities\Device;


class SimpleCalibrator extends BaseCalibrator
{

    function __construct(Device $device)
    {
        parent::__construct($device);
    }

    public function fuel($value)
    {
        $percentage = 0;
        switch ($this->getFuelGroup()) {
            case 'g1':
                $percentage = (99 - (($value - 30) / 6)) * 1.50;
                break;
            case 'g2':
                $percentage = (($value - 30) / 6) * 1.3;
                break;
            default:
                break;
        }
        $percentage = intval(floor($percentage));
        return min(100, max(0, $percentage));
    }

    public function gas($value)
    {
        if ($this->isCngTypeA()) {
            if ($value <= 99) {
                return 4;
            } else if ($value <= 175) {
                return 3;
            } else if ($value <= 250) {
                return 2;
            } else if ($value <= 350) {
                return 1;
            }

            return 0;
        } else {
            if ($value <= 45) {
                return 0;
            } else if ($value <= 75) {
                return 1;
            } else if ($value <= 107) {
                return 2;
            } else if ($value <= 150) {
                return 3;
            }

            return 4;
        }
    }
}
