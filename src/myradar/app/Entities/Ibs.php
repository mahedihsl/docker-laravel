<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Activity.
 *
 * @package namespace App\Entities;
 */
class Ibs extends Eloquent implements Transformable
{
    use TransformableTrait;

    protected $guarded = [];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

}
