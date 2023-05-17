<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Thana extends Eloquent implements Transformable
{
    use TransformableTrait;

    protected $guarded = [];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function fences()
    {
        return $this->hasMany(Fence::class);
    }

}
