<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class StatusLog extends Eloquent implements Transformable
{
    use TransformableTrait;

    protected $guarded = [];

    public function entity()
    {
        return $this->morphTo();
    }

}
