<?php

namespace App\Service\Refuel;

use Illuminate\Support\Collection;
use App\Entities\Car;

class DetectGasRefuelByFiltering extends DetectRefuel
{
    private $count;

    private $type;

    private $range;

    public $log;

    function __construct()
    {
        parent::__construct();

        $this->type = 1; // default CNG type: A
    }

    public function check(Collection $batch)
    {
      $filtered = $this->filterSamples($batch);

      $percentage = ($filtered->count()*100)/$batch->count();
      $minPercentage = config('car.refuelByFiltering.gas.minPercentage');
      if($percentage >= $minPercentage){
        $avg = $filtered->avg();

        return $avg;
      }

      return -1;
    }

    public function filterSamples(Collection $batch)
    {
      $bestIndex = $this->findBestIndex($batch);
      $minDiff = config('car.refuelByFiltering.gas.minDiff');
      $filtered = collect();
      $size = $batch->count();

      if(!is_null($bestIndex)){
        $filtered->push($batch[$bestIndex]);
        $validIndex = $bestIndex;

        for($i = $bestIndex; $i < $size-1 ;$i++){
          if( abs($batch[$i+1]-$batch[$validIndex]) < $minDiff){
            $filtered->push($batch[$i+1]);
            $validIndex = $i+1;
          }
        }

        $validIndex = $bestIndex;
        for($i = $bestIndex; $i > 0 ;$i--){
          if(abs($batch[$i-1]- $batch[$validIndex]) < $minDiff){
            $filtered->prepend($batch[$i-1]);
            $validIndex = $i-1;
          }
        }

      }

      return $filtered;
    }

    public function findBestIndex(Collection $batch)
    {
      $avg = $batch->avg();
      $bestIndex = null;
      $minVal = 1000000000;
      $size = $batch->count();
      for($i = 0;$i<$size;$i++){
        if(abs($batch[$i]-$avg) < $minVal){
          $bestIndex = $i;
          $minVal = abs($batch[$i]-$avg);
        }
      }

      return $bestIndex;
    }
    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function sampleCount()
    {

    }
}
