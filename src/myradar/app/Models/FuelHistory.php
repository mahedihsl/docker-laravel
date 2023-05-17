<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

use App\Service\CalibrationFactory;
use App\Service\Calibration\CalibrationService;

class FuelHistory extends Eloquent
{
    protected $guarded = [];
    protected $dates = ['when'];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function getCalibratedAttribute()
    {
        return CalibrationFactory::fuelValue($this->value);
    }

    public function getOptimalAttribute()
    {
        $service = resolve(CalibrationService::class);
        return $service->fuel($this->device, $this->value);
    }

}
