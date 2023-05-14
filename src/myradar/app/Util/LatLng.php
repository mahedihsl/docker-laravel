<?php

namespace App\Util;

class LatLng
{
    private $lat;
    private $lng;

    function __construct($lat, $lng)
    {
        $this->lat = $lat;
        $this->lng = $lng;
    }

    public function getLat()
    {
        return $this->lat;
    }

    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    public function getLng()
    {
        return $this->lng;
    }

    public function setLng($lng)
    {
        $this->lng = $lng;
    }

    public function getPair()
    {
        return $this->lat . ',' . $this->lng;
    }
}
