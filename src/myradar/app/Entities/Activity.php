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
class Activity extends Eloquent implements Transformable
{
    use TransformableTrait;

    protected $guarded = [];
    protected $dates = ['when'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
