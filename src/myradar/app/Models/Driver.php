<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;
use Carbon\Carbon;

/**
 * Class Driver.
 *
 * @package namespace App\Entities;
 */
class Driver extends Eloquent implements Presentable
{
    use PresentableTrait;

    protected $guarded = [];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    /**
     * Checks if the driver is booked at a particular time
     * @param  Carbon   $time
     * @return boolean
     */
    public function isBookedAt($time)
    {
        return $this->assignments()
                ->where('from', '<', $time)
                    ->where('to', '>', $time)
                        ->exists();
    }

}
