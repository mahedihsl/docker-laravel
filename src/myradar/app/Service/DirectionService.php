<?php

namespace App\Service;

use GuzzleHttp\Client;
use App\Entities\Position;
use Illuminate\Database\Eloquent\Collection;


class DirectionService
{
    private $url;

    /**
     * @var Position
     */
    private $start;

    /**
     * @var Position
     */
    private $end;

    function __construct()
    {
        $this->url = 'https://maps.googleapis.com/maps/api/directions/json';
    }

    public function length(Collection $list)
    {
        $list = $this->filter($list);
        $start = $list->first();
        $end = $list->last();

        $client = new Client();
        $result = $client->get($this->url, [
            'query' => [
                'origin' => "{$start->lat},{$start->lng}",
                'destination' => "{$end->lat},{$end->lng}",
                'waypoints' => $this->waypoints($list),
                'key' => env('MAP_API_KEY'),
            ]
        ]);
        $body = json_decode((string) $result->getBody(), true);
        $distance = 0;
        foreach ($body['routes'][0]['legs'] as $leg) {
            $distance += $leg['distance']['value'];
        }
        return $distance;
    }

    public function waypoints($list)
    {
        $list = $list->splice(10);
        $n = ($list->count() - 2) / 10;
        $n = max(2, intval($n));
        $ret = $list->filter(function($item, $key) use ($n) {
            return $key % $n == 0;
        })->map(function($item) {
            return "{$item->lat},{$item->lng}";
        });
        return implode("|", $ret->toArray());
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

    public function getPath(Position $start, Position $end)
    {
        $this->setStart($start);
        $this->setEnd($end);

        $path = collect();
        $steps = $this->getSteps();
        $len = sizeof($steps);

        for ($i=0; $i < $len; $i++) {
            $path->push($steps[$i]['start_location']);
            if ($i == $len - 1) {
                $path->push($steps[$i]['end_location']);
            }
        }

        return $path;
    }

    private function getSteps()
    {
        $client = new Client();
        $result = $client->get($this->url, [
            'query' => $this->getQueryParams()
        ]);
        $body = json_decode((string) $result->getBody(), true);
        return $body['routes'][0]['legs'][0]['steps'];
    }

    private function getQueryParams()
    {
        return [
            'origin' => $this->start->lat . ',' . $this->start->lng,
            'destination' => $this->end->lat . ',' . $this->end->lng,
            'key' => env('MAP_API_KEY'),
        ];
    }

    public function assignTime($path, $endTime)
    {
        $INTERVAL = 200;
        $step = floor($INTERVAL / ($path->count() + 1));

        for ($i = $path->count() - 1; $i > -1 ; $i--) {
            $endTime -= $step;
            $temp = $path->get($i);
            $temp['time'] = $endTime;
            $path->put($i, $temp);
        }

        return $path;
    }

    private function setStart($start)
    {
        $this->start = $start;
    }

    private function setEnd($end)
    {
        $this->end = $end;
    }

    public function distance($lat1, $lng1, $lat2, $lng2)
    {
        $R = 6371.0e3; // radius of Earth in meter

        $lat1 = $this->degToRad($lat1);
        $lat2 = $this->degToRad($lat2);

        $lng1 = $this->degToRad($lng1);
        $lng2 = $this->degToRad($lng2);

        $dlat = $lat2 - $lat1;
        $dlng = $lng2 - $lng1;

        $a = sin($dlat / 2) * sin($dlat / 2);
        $a += cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);

        return $R * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }

    public function bearing($lat1, $lng1, $lat2, $lng2) {
        $lat1 = deg2rad($lat1);
        $lat2 = deg2rad($lat2);
        $lng1 = deg2rad($lng1);
        $lng2 = deg2rad($lng2);

        $dlng = $lng2 - $lng1;
        $y = sin($dlng) * cos($lat2);
        $x = (cos($lat1) * sin($lat2)) - (sin($lat1) * cos($lat2) * cos($dlng));
        $course = atan2($y, $x);
        $course = rad2deg($course);
        $course = ((($course + 360) % 360));
        return $course;
        
        //$bearingradians = atan2(asin($long1-$long2)*cos($lat2),
        //cos($lat1)*sin($lat2) - sin($lat1)*cos($lat2)*cos($long1-$long2));
        //$bearingdegrees = rad2deg($bearing);

        //return $bearingdegrees;
    }

    private function degToRad($value)
    {
        return $value * M_PI / 180;
    }
}
