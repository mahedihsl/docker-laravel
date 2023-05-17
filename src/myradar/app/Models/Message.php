<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Message.
 *
 * @package namespace App\Entities;
 */
class Message extends Eloquent implements Transformable
{
    use TransformableTrait;

    protected $guarded = [];

    public function getPhoneAttribute($value)
    {
        return $value ? $value : '--';
    }

}
