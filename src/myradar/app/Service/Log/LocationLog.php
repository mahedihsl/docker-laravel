<?php

namespace App\Service\Log;
use Carbon\Carbon;


class LocationLog extends Log
{

    function __construct($carId)
    {
        parent::__construct($carId);
    }

    public function status(Carbon $date)
    {
        return $this->getDevice()
                        ->positions()
                            ->where('when', '>=', $date)
                                ->where('when', '<', $date->copy()->addDay())
                                    ->exists();
    }
}
