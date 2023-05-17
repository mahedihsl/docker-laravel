<?php
namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;

/**
 * Class Trip.
 *
 * @package namespace App\Entities;
 */
class Trip extends Eloquent implements Presentable
{
    use PresentableTrait;

    protected $guarded = [];
    protected $dates = ['start', 'finish'];

    public function getDurationAttribute()
    {
        return $this->start->diffInMinutes($this->finish);
    }

    public function getStartAtAttribute($value)
    {
        return !$value ? '--' : $value;
    }

    public function getFinishAtAttribute($value)
    {
        return !$value ? '--' : $value;
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

}
