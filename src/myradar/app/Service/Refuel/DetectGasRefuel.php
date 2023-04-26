<?php

namespace App\Service\Refuel;

use Illuminate\Support\Collection;
use App\Entities\Car;

class DetectGasRefuel extends DetectRefuel
{
    private $count;

    private $type;

    private $range;

    public $log;

    function __construct()
    {
        parent::__construct();

        $this->type = 1; // default CNG type: A

        $this->count = config('car.refuel.gas.count');
    }

    public function check(Collection $samples)
    {
        $diffs = collect();
        $slice_size = floor($this->count / 2);

        for ($i = $this->count - 1; $i < $samples->count(); $i++) {
            $start = $i - $this->count + 1;
            $avg1 = $samples->slice($start, $slice_size)->average();
            $avg2 = $samples->slice($start + $slice_size, $slice_size)->average();

            $diffs->push([$avg1, $avg2]);
        }

        $filtered = $diffs->filter(function($item) {
            return $this->validate($item[0]-$item[1]);
        });

        $this->magnitude = intval($this->calculateMagnitude($diffs));

        $this->range = $this->calculateRange($diffs, $this->magnitude);

        $identified = ($filtered->count() == $diffs->count())
                        && ($diffs->count() == $this->count - 1)
                        && $this->isValidPeak($diffs);

        $this->log = [
            'flag' => $identified,
            'diffs' => $diffs->toArray(),
            'value' => $this->magnitude,
        ];

        return $identified;
    }

    public function isValidPeak($diffs)
    {
        $diffs = $diffs->map(function($item){
          return $item[0]-$item[1];
        });
        $peak = $this->getType() == Car::CNG_TYPE_A ? $diffs->max() : $diffs->min();
        $mid = $diffs->get($this->middleIndex());
        return abs($peak - $mid) < 1;
    }

    public function sampleCount()
    {
        return ($this->count - 1) * 2;
    }

    public function middleIndex()
    {
        return intval($this->count / 2) - 1;
    }

    public function calculateMagnitude($diffs)
    {
      $diffs = $diffs->map(function($item){
        return $item[0]-$item[1];
      });
        return $this->getType() == Car::CNG_TYPE_A ? $diffs->max() : abs($diffs->min());
    }

    public function calculateRange($diffs,$magnitude)
    {

      return $diffs->first(function($item) use ($magnitude){
        return intval(abs($item[0]-$item[1])) == $magnitude;
      });
    }
    public function range(){
      return $this->range;
    }

    public function validate($val)
    {
        return $this->getType() == Car::CNG_TYPE_A ?
                ($val >= config('car.refuel.gas.thresold')) :
                ($val <= config('car.refuel.gas.thresold2'));
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

}
