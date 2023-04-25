<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Excel;

class GasFilterController extends Controller
{
   public function show(Request $request)
   {
     $gas = 'Fuel_Export_Dr.  M Shahabuddin Ahmed.xls';
     $data = Excel::load('storage/exports/fuel/'. $gas)->get();
     $engineType = 2;
     $gasvalues = collect();
     foreach ($data as $key => $value) {
       if($value['fuel_value']<=20){
         continue;
       }
       $gasvalues->push([$value['date_time'],$value['fuel_value']]);
     }
     $result = collect();
     $mainBatch = collect();
     $prevGas = null;
     $prevTime = new Carbon();
     $faultTime = new Carbon();
     $faultyBatch = collect();
     $prevBest = null;
     $prevbatch = collect();
     $prevfiltered = collect();

     $vavu =0;
     $wholesize = $gasvalues->count();
     for($x=0;$x<$wholesize;$x++) {
       if($mainBatch->count()<100)
       {
         $mainBatch->push($gasvalues[$x]);
       }
       else{
         $x--;
         $avgarr = collect();
         $batch = collect();
         $batch = $mainBatch;
         foreach ($batch as $key => $value) {
           $avgarr->push($value[1]);
         }
         $avg = $avgarr->avg();


         $batch = $batch->sortBy(function($item, $key){
           return $item[1];
         });
         $batch = collect($batch->values()->all());

         $size = $batch->count();
         $bestIndex = null;
         $minVal = 100000;

         for($i = 0;$i<$size;$i++){
           if(abs($batch[$i][1]-$avg) < $minVal){
             $bestIndex = $i;
             $minVal = abs($batch[$i][1]-$avg);
           }
         }



         $filtered = collect();
         $filtered->push($batch[$bestIndex]);
         $validIndex = $bestIndex;
         for($i = $bestIndex; $i < $size-1 ;$i++){
           if( abs($batch[$i+1][1]-$batch[$validIndex][1]) < 20){
             $filtered->push($batch[$i+1]);
             $validIndex = $i+1;
           }
         }
         $validIndex = $bestIndex;
         for($i = $bestIndex; $i > 0 ;$i--){
           if(abs($batch[$i-1][1]- $batch[$validIndex][1]) < 20){
             $filtered->prepend($batch[$i-1]);
             $validIndex = $i-1;
           }
         }
         // if($vavu++<20){
         //   $result->push(['batch' => $batch, 'filtered' => $filtered, 'bestval' => $batch[$bestIndex], '$bestIndex' => $bestIndex]);
         // }
         // else{
         //   break;
         // }

         $prevValue =0;

         $percentage = ($filtered->count()*100)/$batch->count();

         if($percentage >= 80){

            $avgarr = collect();
            $time = new Carbon();
            $startTime = new Carbon();

            $inc = 0;
            foreach ($filtered as $key => $value) {
              if($inc == 0){
                $startTime = $value[0];
                $time = $value[0];
              }
              $inc = 1;

              $avgarr->push($value[1]);
            }
            // $filteredSize = $filtered->count();
            // $slice = $avgarr->slice($filteredSize/2);
            // $latestGas = $slice->avg();
            $latestGas = $avgarr->avg();
            if($prevGas === null){
              $prevGas = $latestGas;
              $prevTime = $time;
            }
            else {
              $magnitude =  $prevGas-$latestGas;
              $base = $prevGas;

              if($magnitude > 60){
                  $result->push(['time' => $time, 'magnitude' => round($magnitude), 'base' => round($base),'$prevbatch' => $prevbatch, 'prevfiltered' => $prevfiltered, 'filtered'=> $filtered, 'bestval' => $batch[$bestIndex], 'prevBest' => $prevBest]);
              }

              $prevTime = $time;
              $prevGas = $latestGas;
              $prevBest = $batch[$bestIndex];
              $prevbatch = collect();
              $prevfiltered = collect();
              $prevfiltered = $prevfiltered->merge($filtered);
              $prevbatch = $prevbatch->merge($batch);
            }
            $mainBatch->shift();
         }
         else{
           foreach ($mainBatch as $key => $value) {
               $faultTime = $value[0];
           }
           $mainBatch = collect();
           //$faultyBatch = $batch;
         }

        }
     }
     dd($result);
     return $result;
     // $avg = $data->avg();
     // $filtered = collect();
     // foreach ($data as $key => $value) {
     //   if(abs($value-$avg)>50)
     //      continue;
     //    $filtered->push($value);
     // }
     // dd($filtered, $avg, $data->count(), $filtered->count(), $filtered->avg());
   }



}
