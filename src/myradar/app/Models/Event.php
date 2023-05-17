<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;
use Carbon\Carbon;
/**
 * Class Event.
 *
 * @package namespace App\Entities;
 */
class Event extends Eloquent implements Presentable
{
    use PresentableTrait, SoftDeletes;

    const TYPE_ON = 1;
    const TYPE_OFF = 2;
    const TYPE_REFUEL = 3;
    const TYPE_DOOR = 4;
    const TYPE_AC = 5;
    const TYPE_PANIC = 6;
    const TYPE_REFUEL_BF =7;
    const TYPE_FUEL_REFUEL =8;
    const TYPE_SPEED = 9;
    const TYPE_GEOFENCE = 10;

    const MODE_PRIVATE = 1;
    const MODE_PUBLIC = 2;

    protected $guarded = [];
    protected $dates = ['deleted_at'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function gas_refuel_input()
    {
      return $this->hasOne(GasRefuelInput::class);
    }
}
