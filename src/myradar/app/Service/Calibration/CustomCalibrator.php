<?php

namespace App\Service\Calibration;

use App\Entities\Device;
use App\Entities\GasCalibration;
use App\Entities\FuelCalibration;

use Illuminate\Support\Facades\Log;


class CustomCalibrator extends BaseCalibrator
{

    function __construct(Device $device)
    {
        parent::__construct($device);
    }

    public function lastFuelCalibrationData()
    {
        $data = FuelCalibration::where('device_id', $this->getDevice()->id)
                    ->orderBy('created_at', 'desc')
                        ->first()->data;
        return collect($data)->filter(function($row) {
            return intval($row['perc']) > 0 || intval($row['value']) > 0;
        })->sortBy('perc')->values();
    }

    public function getTerminalFuelValues($avgValue)
    {
        $data = $this->lastFuelCalibrationData();
        if ($data->count() < 2) {
            return [null, null];
        }

        for ($i = 0; $i < $data->count() - 1; $i++) { 
            $current = $data->get($i);
            $next = $data->get($i + 1);
            if ($avgValue <= $current['value'] && $avgValue > $next['value']) {
                return [$current, $next];
            }
        }

        if ($avgValue >= $data->first()['value']) {
            return [$data->first(), null];
        }
        if ($avgValue <= $data->last()['value']) {
            return [$data->last(), null];
        }

        return [null, null];
    }

    public function fuelPercentage($avgValue)
    {
        list($start, $end) = $this->getTerminalFuelValues($avgValue);
        if (!$start && !$end) return 0;
        if (!$end) return $start['perc'];

        $slope = ($end['perc'] - $start['perc']) / ($end['value'] - $start['value']);
        $c = $start['perc'] - ($slope * $start['value']);
        $finalValue = ($slope * $avgValue) + $c;
        return max(min($finalValue, 100), 0);
    }

    public function fuel($value)
    {
        if (in_array($this->getDevice()->com_id, [19935, 39114])) {
            return $this->fuelPercentage($value);
        }

        $data = FuelCalibration::where('device_id', $this->getDevice()->id)
                    ->orderBy('created_at', 'desc')
                        ->first()->data;

        $st = null;
        $en = null;
        foreach ($data as $key => $arr) {
            if ($value < $arr['value']) {
                $st = $arr;
                break;
            } else {
                $en = $arr;
            }
        }

        if (is_null($en)) return 100;
        if (is_null($st)) return 0;

        $delPerc = $en['perc'] - $st['perc'];
        $delVal = $st['value'] - $en['value'];
        $inter = ($delPerc / $delVal) * ($st['value'] - $value);

        return min(100, floor($st['perc'] + $inter));
    }

    public function newFuel($value)
    {
      $data = FuelCalibration::where('device_id', $this->getDevice()->id)
                  ->orderBy('created_at', 'desc')
                      ->first()->data;

      return $this->getPerc($data, $value);
    }

    public function getPerc($data, $value)
    {
      $last = null;
      $len = sizeof($data);

      for ($i=0; $i < $len; $i++) {
          if ($value <= $data[$i]['value']) {
              if (is_null($last)) {
                  return $data[$i]['perc'];
              }

              $frac = ($value - $last['value']) / ($data[$i]['value'] - $last['value']);
              return $last['perc'] + (($data[$i]['perc'] - $last['perc']) * $frac);
          }
          $last = $data[$i];
      }

      return $data[$len - 1]['perc'];
    }

    public function gas($value)
    {
        $data = GasCalibration::where('device_id', $this->getDevice()->id)
                    ->orderBy('created_at', 'desc')
                        ->first()->data;

        if ($this->isCngTypeB()) {
            $data = $data->reverse();
        }

        foreach ($data as $key => $arr) {
            if ($value < $arr['value']) {
                return $arr['level'];
            }
        }

        return $this->isCngTypeB() ? 4 : 0;
    }
}
