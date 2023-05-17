<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;

/**
 * Class Unstable.
 *
 * @package namespace App\Entities;
 */
class Unstable extends Eloquent implements Presentable
{
    use PresentableTrait;

    protected $guarded = [];
    protected $dates = ['when'];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

}
