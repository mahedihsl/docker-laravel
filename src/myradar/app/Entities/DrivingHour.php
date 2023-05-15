<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Carbon\Carbon;

class DrivingHour extends Eloquent
{
    protected $guarded = [];
    protected $dates = ['start', 'when'];
    protected $casts = [
        'duration' => 'integer',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

}
