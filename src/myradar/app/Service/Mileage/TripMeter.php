<?php

namespace App\Service\Mileage;

use Illuminate\Database\Eloquent\Collection;

class TripMeter
{
    // use LatLngFilter;

    function __construct()
    {
        // code...
    }

    public function calculate(Collection $list, $filter = true)
    {
        $distance = 0.0;

        if ($filter == true) {
            $list = $this->filter($list);
        }

        if ($list->count() < 2) {
            return 0;
        }

        for ($i = 1; $i < $list->count(); $i++) {
            $distance += $list->get($i)->distance($list->get($i - 1));
        }

        return intval($distance);
    }

    function filter(Collection $list)
    {
        $thresold = config('car.mileage.position.diff');

        $filtered = collect();
        $filtered->push($list->first());

        for ($i = 1; $i < $list->count(); $i++) {
            if ($filtered->last()->distance($list->get($i)) > $thresold) {
                $filtered->push($list->get($i));
            }
        }

        return $filtered;
    }

}
