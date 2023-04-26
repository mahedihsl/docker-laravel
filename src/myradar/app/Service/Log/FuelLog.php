<?php

namespace App\Service\Log;
use Carbon\Carbon;


class FuelLog extends Log
{

    function __construct($carId)
    {
        parent::__construct($carId);
    }

    public function status(Carbon $date)
    {
        return $this->getDevice()
                        ->fuel_histories()
                            ->where('when', '>=', $date)
                                ->where('when', '<', $date->copy()->addDay())
                                    ->exists();
    }
}
