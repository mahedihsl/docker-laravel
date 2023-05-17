<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Fence extends Eloquent implements Transformable
{
    use TransformableTrait;

    protected $guarded = [];

    public function isCustomFence()
    {
        return $this->car_id && !$this->thana_id;
    }

    public function getLatAttribute($value)
    {
        return round($value, 6);
    }

    public function getLngAttribute($value)
    {
        return round($value, 6);
    }

    public function cars()
    {
        return $this->belongsToMany(Car::class);
    }

    public function thana()
    {
        return $this->belongsTo(Thana::class);
    }

}
