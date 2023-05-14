<?php

namespace App\Service\Refuel;

use Illuminate\Support\Collection;
use App\Entities\Device;
use App\Entities\Car;
use App\Entities\FuelHistory;
use App\Service\NotificationService;
use App\Jobs\PushNotificationJob;
use App\Service\Microservice\PushMicroservice;
use Illuminate\Support\Facades\Log;

class DetectFuelRefuel extends DetectRefuel
{
    const COUNT = 10;

    function __construct()
    {
        parent::__construct();
    }

    public function check(Collection $batch)
    {
      $batch = $batch->sort();
      $batch = collect($batch->values()->all());

      $filtered = $this->filterSamples($batch);
      $percentage = ($filtered->count()*100)/$batch->count();
      $minPercentage = config('car.refuelByFiltering.fuel.minPercentage');
      if($percentage >= $minPercentage){
        $avg = $filtered->avg();

        return $avg;
      }

      return -1;
    }

    public function filterSamples(Collection $batch)
    {
      $bestIndex = $this->findBestIndex($batch);
      $minDiff = config('car.refuelByFiltering.fuel.minDiff');
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

    public function message($deviceId)
    {
        $device = Device::find($deviceId);
        $data = collect([
            'title' => 'Alert for car: ' . $device->car->reg_no,
            'body' => 'Your car has taken fuel of ' . $this->price() . ' Taka',
            'type' => NotificationService::$TYPE_FUEL,
        ]);

        $service = new PushMicroservice();
        $service->send($device->user_id, $data);
    }

    private function price()
    {
        return $this->magnitude() * $this->priceFactor;
    }

    public function sampleCount()
    {
        return (self::COUNT - 1) * 2;
    }

}
