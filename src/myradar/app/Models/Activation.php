<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Carbon\Carbon;

/**
 * Class Activation.
 *
 * @package namespace App\Entities;
 */
class Activation extends Eloquent implements Transformable
{
    use TransformableTrait;

    protected $guarded = [];

    public function getKeyAttribute()
    {
        return $this->code . '-' . sprintf("%'.03d", $this->serial);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function totalBill()
    {
        // $months = $this->created_at->diffInMonths(Carbon::today());
        // return $months * $this->car->bill;
        $start_date = $this->created_at;
        $start_date->addMonth();
        $start_date->day = 1;

        $months = 0;
        while ($start_date->lessThanOrEqualTo(Carbon::today())) {
            $months++;
            $start_date->addMonth();
        }
        return $months * $this->car->bill;
    }

    public function totalPaid()
    {
        return $this->car->payments()->sum('amount');
    }

    public function totalWaive()
    {
        return $this->car->payments()->sum('waive');
    }

}
