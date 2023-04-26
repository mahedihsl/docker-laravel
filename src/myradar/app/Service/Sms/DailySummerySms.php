<?php

namespace App\Service\Sms;

use App\Entities\Car;
use App\Entities\Event;
use App\Entities\Mileage;
use App\Entities\DutyHour;
use App\Entities\DrivingHour;
use Carbon\Carbon;


class DailySummerySms
{
    private $car;
    private $date;

    function __construct(Car $car, Carbon $date)
    {
        $this->car = $car;
        $this->date = $date;
    }

    public function content()
    {
        $ret = "Report of " . $this->date->format("jS M") . " (" . $this->car->reg_no . ")\n\n";

        $temp = $this->getDutyHour();
        $ret .= $this->firstEngineOn($temp);
        $ret .= $this->lastEngineOff($temp);
        $ret .= $this->totalEngineOn();
        $ret .= $this->totalMileage();
        // $ret .= $this->getSpeedLimit();
        $ret .= $this->getDrivingHour();

        return $ret;
    }

    public function firstEngineOn($duty)
    {
        $suff = is_null($duty) || is_null($duty->start) ? 'N/A' : $duty->start->format('g:i a');
        return "First Engine ON - " . $suff . "\n";
    }

    public function lastEngineOff($duty)
    {
        $suff = is_null($duty) || is_null($duty->finish) ? 'N/A' : $duty->finish->format('g:i a');
        return "Last Engine OFF - " . $suff . "\n";
    }

    public function totalEngineOn()
    {
        $nextDay = $this->date->copy()->addDay();
        $count = Event::where('car_id', $this->car->id)
                        ->where('type', Event::TYPE_ON)
                        ->where('created_at', '>=', $this->date)
                        ->where('created_at', '<', $nextDay)
                        ->count();
        return "Engine On - " . $count . " times\n";
    }

    public function totalMileage()
    {
        $mileage = Mileage::where('car_id', $this->car->id)
                        ->where('when', $this->date)
                        ->first();
        $dist = is_null($mileage) ? 0 : $mileage->value;
        $dist = round($dist / 1000, 1);
        return "Mileage - " . $dist . " km\n";
    }

    public function getDutyHour()
    {
        return DutyHour::where('car_id', $this->car->id)
                        ->where('when', $this->date)
                        ->first();
    }

    public function getSpeedLimit()
    {
        $nextDay = $this->date->copy()->addDay();
        $count = Event::where('car_id', $this->car->id)
                        ->where('type', Event::TYPE_SPEED)
                        ->where('created_at', '>=', $this->date)
                        ->where('created_at', '<', $nextDay)
                        ->count();
        return "Speed Limit Cross - " . $count . " times\n";
    }

    public function getDrivingHour()
    {
        $record = DrivingHour::where('car_id', $this->car->id)
                        ->where('when', $this->date)
                        ->first();
        $val = is_null($record) ? "N/A" : $this->formatDrivingHour($record->duration);
        return "Driving Hour - " . $val;
    }

    public function formatDrivingHour($val)
    {
        $x = intval($val / 60);
        $y = $val % 60;

        $hr = "";
        if ($x == 1) $hr = "1 hr";
        if ($x > 1) $hr = $x . " hrs";

        $mn = "";
        if ($y == 1) $mn = "1 min";
        if ($y > 1) $mn = $y . " mins";

        return $hr . " " . $mn;
    }
}
