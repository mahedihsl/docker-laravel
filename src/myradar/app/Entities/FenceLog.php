<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class FenceLog extends Eloquent implements Transformable
{
    use TransformableTrait;

    protected $guarded = [];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function fence()
    {
        return $this->belongsTo(Fence::class);
    }

}
