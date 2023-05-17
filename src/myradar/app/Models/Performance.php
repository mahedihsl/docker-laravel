<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;

/**
 * Class Performance.
 *
 * @package namespace App\Entities;
 */
class Performance extends Eloquent implements Presentable
{
    use PresentableTrait;

    protected $guarded = [];
    protected $dates = ['when'];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

}
