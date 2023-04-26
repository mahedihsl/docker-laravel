<?php

namespace App\Service;

class CalibrationFactory
{
    public static function fuelValue($value)
    {
        // TODO: change fuel calibration method
        return $value / 100;
    }

    public static function gasValue($value)
    {
        if ($value < 100) {
            return 4;
        } else if ($value <= 151) {
            return 3;
        } else if ($value <= 203) {
            return 2;
        } else if ($value <= 255) {
            return 1;
        }

        return 0;
    }
}
