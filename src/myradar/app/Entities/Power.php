<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Power extends Eloquent
{
    protected $guarded = [];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
