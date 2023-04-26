<?php

namespace App\Service\Log;
use Carbon\Carbon;


class ServiceLog
{
    /**
     * id of the car
     * @var string
     */
    private $carId;

    /**
     * number representing service
     * 0 = Lat/Lng, 1 = Fuel, 2 = Gas, 3 = Engine Status
     * @var int
     */
    private $service;

    function __construct($carId, $service)
    {
        $this->carId = $carId;
        $this->service = $service;
    }

    public function get()
    {
        $result = [];
        $date = Carbon::today();
        $logger = $this->getLogger();
        for ($i = 0; $i < 15; $i++) {
            $result[] = [
                'date' => $date->format('j M'),
                'status' => $logger->status($date),
            ];
            $date = $date->copy()->subDay();
        }
        return $result;
    }

    private function getLogger()
    {
        try {
            if ($this->service == 0) return new LocationLog($this->carId);
            if ($this->service == 1) return new FuelLog($this->carId);
            if ($this->service == 2) return new GasLog($this->carId);
            if ($this->service == 3) return new EngineLog($this->carId);
        } catch (Exception $e) {}

        return null;
    }
}
