<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Geofence extends Eloquent implements Transformable
{
    use TransformableTrait;

    protected $guarded = [];

    public function getCarsAttribute($value)
    {
        return !$value ? [] : $value;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
