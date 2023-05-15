<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Health extends Eloquent implements Transformable
{
    use TransformableTrait;

    protected $guarded = [];

    public function mcucsr() {
        $value = $this->mcu;
        if ($value == null) return '--';
        $str = decbin($value);
        while(strlen($str) < 5) {
            $str = '0' . $str;
        }
        return $str;
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

}
