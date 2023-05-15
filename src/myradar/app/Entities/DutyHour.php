<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;

/**
 * Class DutyHour.
 *
 * @package namespace App\Entities;
 */
class DutyHour extends Eloquent implements Presentable
{
    use PresentableTrait;

    protected $guarded = [];
    protected $dates = ['start', 'finish', 'when'];
    protected $casts = [
        'duration' => 'integer',
    ];

    public function getStartFormatAttribute()
    {
        return is_null($this->start) ? 'N/A' : $this->start->format('g:i a');
    }

    public function getFinishFormatAttribute()
    {
        return is_null($this->finish) ? 'N/A' : $this->finish->format('g:i a');
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }


}
