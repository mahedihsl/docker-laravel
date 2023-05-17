<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Poi extends Eloquent implements Transformable
{
    use TransformableTrait;

    protected $guarded = [];

}
