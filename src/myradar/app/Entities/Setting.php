<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Setting extends Eloquent implements Transformable
{
    use TransformableTrait;

    protected $guarded = [];

    protected $casts = [
        'noti_engine'   => 'boolean',
        'noti_geofence' => 'boolean',
        'noti_date'     => 'boolean',
        'noti_speed'    => 'boolean',
        'sms_pack1'     => 'boolean',
        'sms_pack2'     => 'boolean',
    ];

    public function getSmsPack1Attribute($value)
    {
        return is_null($value) ? FALSE : boolval($value);
    }

    public function getSmsPack2Attribute($value)
    {
        return is_null($value) ? FALSE : boolval($value);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function car()
    {
      return $this->belongsTo(Car::class);
    }

}
