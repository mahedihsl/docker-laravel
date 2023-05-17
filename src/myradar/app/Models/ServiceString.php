<?php

namespace App\Models;

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
