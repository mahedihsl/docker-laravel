<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ServiceString extends Eloquent
{
    protected $guarded = [];

    public function getDataAttribute($value)
    {
        $vals = [];
        foreach ($value as $key => $value) {
            $vals[] = "$key=$value";
        }
        return implode(', ', $vals);
    }
}
