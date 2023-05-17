<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MetaData.
 *
 * @package namespace App\Entities;
 */
class MetaData extends Eloquent implements Transformable
{
    use TransformableTrait;

    protected $guarded = [];
    protected $dates = ['engine_on'];

    public function getGasFactorAttribute($attr)
    {
        if ( ! $attr) {
            return [
                'value' => config('car.refuel.gas.factor'),
                'status' => false,
            ];
        }

        return $attr;
    }

    public function getFuelFactorAttribute($attr)
    {
        if ( ! $attr) {
            return [
                'value' => 0.1,
                'status' => false,
            ];
        }

        return $attr;
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
