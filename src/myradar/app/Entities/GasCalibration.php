<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class GasCalibration.
 *
 * @package namespace App\Entities;
 */
class GasCalibration extends Eloquent implements Transformable
{
    use TransformableTrait;

    protected $guarded = [];

    public function getDataAttribute($data)
    {
        return collect($data)->map(function($v) {
            return [
                'level' => intval($v['level']),
                'value' => intval($v['value']),
            ];
        })->reverse();
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
