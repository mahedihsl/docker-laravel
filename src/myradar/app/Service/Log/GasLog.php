<?php

namespace App\Service\Log;
use Carbon\Carbon;


class GasLog extends Log
{

    function __construct($carId)
    {
        parent::__construct($carId);
    }

    public function status(Carbon $date)
    {
        return $this->getDevice()
                        ->gas_histories()
                            ->where('when', '>=', $date)
                                ->where('when', '<', $date->copy()->addDay())
                                    ->exists();
    }
}
