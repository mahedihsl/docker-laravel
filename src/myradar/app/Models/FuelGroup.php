<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

use App\Service\CalibrationFactory;
use App\Service\Calibration\CalibrationService;

class FuelGroup extends Eloquent
{
    protected $guarded = [];

    public function findRefuelPercentage($magnitude)
    {
        $fraction = abs($magnitude) / abs($this->maxValue - $this->minValue);
        return intval($fraction * 100);
    }

}
