<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class RefuelFeed.
 *
 * @package namespace App\Entities;
 */
class RefuelFeed extends Eloquent implements Transformable
{
    use TransformableTrait;

    public static $TYPE_FUEL = 0;
    public static $TYPE_GAS = 1;

    public static $METHOD_REFUEL = 0;
    public static $METHOD_RESERVE = 1;

    protected $guarded = [];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

}
