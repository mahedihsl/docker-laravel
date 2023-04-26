<?php

namespace App\Service;

class PackageService
{
    const LATLNG    = 1;
    const ENGINE    = 2;
    const FUEL      = 3;
    const GAS       = 4;
    const MILEAGE   = 5;
    const GEOFENCE  = 6;
    const SPEED     = 7;
    const NS        = 8;
    const PANIC     = 9;
    const TRIP      = 10;
    const IBS       = 11;

    const CAR_BASIC = 0;
    const CAR_PRO_1 = 1;
    const CAR_PRO_2 = 4;
    const CAR_PRO_3 = 5;
    const BIKE_BASIC = 2;
    const BIKE_PRO = 3;

    private $package1; // Car Basic
    private $package2; // Car Pro
    private $package5; // Car Pro II
    private $package6; // Car Pro III
    private $package3; // Bike Basic
    private $package4; // Bike Pro

    function __construct()
    {
        $this->package1 = [self::LATLNG, self::ENGINE, self::MILEAGE, self::GEOFENCE, self::SPEED];
        $this->package2 = [self::LATLNG, self::ENGINE, self::GAS, self::MILEAGE, self::GEOFENCE, self::SPEED];
        $this->package5 = [self::LATLNG, self::ENGINE, self::FUEL, self::GAS, self::MILEAGE, self::GEOFENCE, self::SPEED];
        $this->package6 = [self::LATLNG, self::ENGINE, self::FUEL, self::MILEAGE, self::GEOFENCE, self::SPEED];
        $this->package3 = [self::ENGINE];
        $this->package4 = [self::LATLNG, self::ENGINE, self::MILEAGE];
    }

    public function basicCar()
    {
        return [
            'id' => 0,
            'name' => 'Standard',
            'services' => $this->package1,
            'labels' => $this->getServiceNames($this->package1),
        ];
    }

    public function proCar()
    {
        return [
            'id' => 1,
            'name' => 'Special (Gas Only)',
            'services' => $this->package2,
            'labels' => $this->getServiceNames($this->package2),
        ];
    }

    public function proCarII()
    {
        return [
            'id' => 4,
            'name' => 'Premium (Gas & Fuel)',
            'services' => $this->package5,
            'labels' => $this->getServiceNames($this->package5),
        ];
    }
    
    public function proCarIII()
    {
        return [
            'id' => 5,
            'name' => 'Advanced (Fuel Only)',
            'services' => $this->package6,
            'labels' => $this->getServiceNames($this->package6),
        ];
    }

    public function basicBike()
    {
        return [
            'id' => 2,
            'name' => 'Bike Basic',
            'services' => $this->package3,
            'labels' => $this->getServiceNames($this->package3),
        ];
    }

    public function proBike()
    {
        return [
            'id' => 3,
            'name' => 'Bike Pro',
            'services' => $this->package4,
            'labels' => $this->getServiceNames($this->package4),
        ];
    }

    public function getPackageId($services)
    {
        if ($services == $this->package1) {
            return self::CAR_BASIC;
        } else if ($services == $this->package2) {
            return self::CAR_PRO_1;
        } else if ($services == $this->package5) {
            return self::CAR_PRO_2;
        } else if ($services == $this->package6) {
            return self::CAR_PRO_3;
        } else if ($services == $this->package3) {
            return self::BIKE_BASIC;
        } else if ($services == $this->package4) {
            return self::BIKE_PRO;
        }

        return -1;
    }

    public function getServiceNames($services)
    {
        if (is_array($services)) $services = collect($services);

        return $services->map(function($t) {
            return $this->getLabel($t);
        })->toArray();
    }

    private function getLabel($tag)
    {
        switch ($tag) {
            case self::LATLNG:
                return 'Tracking';
            case self::ENGINE:
                return 'Engine Lock';
            case self::FUEL:
                return 'Fuel';
            case self::GAS:
                return 'Gas';
            case self::MILEAGE:
                return 'Mileage Report';
            case self::GEOFENCE:
                return 'Geofence';
            case self::SPEED:
                return 'Speed';

            default:
                return '';
        }
    }
}
