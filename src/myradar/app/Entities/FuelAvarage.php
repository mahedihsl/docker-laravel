<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;

class FuelAvarage extends Eloquent implements Presentable
{
    use PresentableTrait;

    protected $guarded = [];
    protected $dates = ['when'];
    protected $table = 'fuel_avarage';
    public $timestamps = false;

}
