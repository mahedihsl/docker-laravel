<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use App\Service\DirectionService;

use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;

class Position extends Eloquent implements Presentable
{
    use PresentableTrait, SoftDeletes;

    protected $guarded = [];
    protected $dates = ['when', 'deleted_at'];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
    public function distance(Position $pos)
    {
        $service = new DirectionService();
        return $service->distance($this->lat, $this->lng, $pos->lat, $pos->lng);
    }

    public function getSpeedAttribute($value)
    {
        return is_null($value) ? 0 : $value;
    }

    public function findSpeed(Position $pos)
    {
        try {
            $km = $this->distance($pos) / 1000;
            $hour = abs($this->when->timestamp - $pos->when->timestamp) / 3600;
            return $km / $hour;
        } catch (\Exception $e) {
            return 10000;
        }
    }
}
