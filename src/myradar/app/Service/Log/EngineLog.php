<?php

namespace App\Service\Log;
use Carbon\Carbon;


class EngineLog extends Log
{

    function __construct($carId)
    {
        parent::__construct($carId);
    }

    public function status(Carbon $date)
    {
        return false;
    }
}
