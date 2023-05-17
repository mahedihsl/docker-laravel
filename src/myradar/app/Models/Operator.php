<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Operator extends Eloquent implements Transformable
{
    use TransformableTrait;

    protected $guarded = [];

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function image()
    {
        return $this->morphOne(Photo::class, 'imageable');
    }

}
