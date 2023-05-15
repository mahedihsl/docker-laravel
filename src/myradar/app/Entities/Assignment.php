<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;

/**
 * Class Assignment.
 *
 * @package namespace App\Entities;
 */
class Assignment extends Eloquent implements Presentable
{
    use PresentableTrait;

    const TYPE_EMPLOYEE = 1;
    const TYPE_LOGISTICS = 2;
    const TYPE_OTHER = 3;

    const STATUS_OVER = 0;
    const STATUS_ACTIVE = 1;

    protected $guarded = [];
    protected $dates = ['from', 'to'];
    protected $casts = [
        'type' => 'integer',
        'status' => 'integer',
    ];

    public function getDurationAttribute()
    {
      return $this->from->diffInHours($this->to);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

}
