<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Carbon\Carbon;

class Payment extends Eloquent implements Transformable
{
    use TransformableTrait;

    protected $guarded = [];
    protected $dates = ['paid_on'];
    protected $casts = [
        'type' => 'integer',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getValidity()
    {
        $last = collect($this->months)
                    ->sortByDesc(function($product, $key) {
                        return ($product[1] * 12) + $product[0];
                    })
                    ->first();
        $months = collect([
            'Jan', 'Feb', 'Mar',
            'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep',
            'Oct', 'Nov', 'Dec',
        ]);

        return $months->get($last[0]) . ' ' . $last[1];
    }

    public function getMonthRangeAttribute()
    {
        $x = sizeof($this->months);

        if ($x == 0) return '-- : --';
        if ($x == 1) {
            $temp = $this->months[0];
            return Carbon::createFromDate($temp[1], $temp[0] + 1, 1)->format("M'y");
        }

        $temp1 = $this->months[0];
        $temp2 = $this->months[$x - 1];
        $c1 = Carbon::createFromDate($temp1[1], $temp1[0] + 1, 1);
        $c2 = Carbon::createFromDate($temp2[1], $temp2[0] + 1, 1);

        $delim = $x == 2 ? " & " : " to ";
        return $c1->format("M'y") . $delim . $c2->format("M'y");
    }

    public function getExtraAttribute($value)
    {

      if(is_null($value))
        return 0;
      return $value;
    }

    public function getMethodAttribute()
    {
        $types = [
            'Cash',
            'bKash',
            'bKash Personal',
            'Rocket',
            'Rocket Personal',
            'Bank',
            'Visa',
            'MasterCard',
            'bKash (907)',
            'bKash (909)'
        ];

        if ( ! $this->type) {
            return '--';
        }

        return $types[$this->type - 1];
    }

    public function getPaidAmountForMonth($month, $year)
    {
        $month = intval($month) - 1;
        $year = intval($year);

        $monthlyBill = $this->car->bill;
        $paidAmount = $this->amount;

        foreach ($this->months as $item) {
            if (intval($item[0]) == $month && intval($item[1]) == $year) {
                $paidAmount = max($paidAmount, 0);
                $paidAmount = min($paidAmount, $monthlyBill);
                return $paidAmount;
            }
            $paidAmount -= $monthlyBill;
        }
        return 0;
    }

}
