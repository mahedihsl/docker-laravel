<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

use App\Service\CalibrationFactory;
use App\Service\Calibration\CalibrationService;

class GasHistory extends Eloquent
{
    use SoftDeletes;

    protected $guarded = [];
    protected $dates = ['when', 'deleted_at'];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function getCalibratedAttribute()
    {
        return CalibrationFactory::gasValue($this->value);
    }

    public function getOptimalAttribute()
    {
        $service = resolve(CalibrationService::class);
        return $service->gas($this->device, $this->value);
    }
}
