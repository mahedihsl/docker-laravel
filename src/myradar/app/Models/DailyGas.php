<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;

class DailyGas extends Eloquent implements Presentable
{
    use PresentableTrait, SoftDeletes;

    protected $guarded = [];
    protected $dates = ['when', 'deleted_at'];

    public function getValueAttribute($value)
    {
        return intval($value);
    }

}
