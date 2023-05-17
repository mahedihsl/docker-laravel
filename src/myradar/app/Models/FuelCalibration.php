<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class FuelCalibration.
 *
 * @package namespace App\Entities;
 */
class FuelCalibration extends Eloquent implements Transformable
{
    use TransformableTrait;

    protected $guarded = [];

    public function getDataAttribute($data)
    {
        return collect($data)->map(function($v) {
            return [
                'perc' => intval($v['perc']),
                'value' => intval($v['value']),
            ];
        });
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

}
