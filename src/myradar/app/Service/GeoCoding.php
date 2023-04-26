<?php

namespace App\Service;

use App\Util\LatLng;
use GuzzleHttp;

class GeoCoding
{

    private $latlng;

    function __construct(LatLng $latlng)
    {
        $this->latlng = $latlng;
    }

    public function getLocation()
    {
        $client = new GuzzleHttp\Client();
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='
            .$this->latlng->getPair().'&key='.env('API_KEY');
        $res = $client->request('GET', $url);

        if ($res->getStatusCode() == 200) {
            $data = json_decode($res->getBody(), true);
            if (sizeof($data['results']) > 0) {
                return $data['results'][0]['formatted_address'];
            }
        }

        return 'Unknown Location';
    }
}
