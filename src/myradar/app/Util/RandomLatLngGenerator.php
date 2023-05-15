<?php

namespace App\Util;

class RandomLatLngGenerator
{
    private $directions = [
        [0.0001, 0],
        [0.0001, -0.0001],
        [0, -0.0001],
        [-0.0001, -0.0001],
        [-0.0001, 0],
        [-0.0001, 0.0001],
        [0, 0.0001],
        [0.0001, 0.0001],
    ];

    private $dir;

    private $latlng;

    function __construct()
    {
        $this->dir = $this->directions[rand(0, 7)];
        $this->latlng = new LatLng(
            23 + (rand(71000000, 88000000) / 100000000),
            90 + (rand(34000000, 44000000) / 100000000)
        );
    }

    public function getNextLatLng()
    {
        $lat = $this->latlng->getLat() + $this->dir[0];
        $lng = $this->latlng->getLng() + $this->dir[1];

        $this->latlng = new LatLng($lat, $lng);

        return $this->latlng;
    }
}
