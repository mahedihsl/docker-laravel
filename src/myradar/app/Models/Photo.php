<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Photo extends Eloquent
{
    protected $guarded = [];

    public function imageable()
    {
        return $this->morphTo();
    }

    public function getUrlAttribute($value)
    {
        if (!$value) {
            $value = 'image/user-placeholder.jpg';
        }

        return \Storage::url($value);
    }
}
