<?php

namespace App\Http\Controllers\Test;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entities\Position;
use App\Entities\Device;
use App\Service\DirectionService;
use Carbon\Carbon;
use Excel;

class MileageTestController extends Controller
{
    //



    public function show(){

      // $year = 2018; $month = 10; $day = 2;
      // $from_date = Carbon::createFromFormat('Y-m-d H', '2018-10-03 03');
      // $to_date = Carbon::createFromFormat('Y-m-d H', '2018-10-04 03');
      //
      // // $fName = 'sayeda.xls';
      // // $arr = [];
      // // $rows = Excel::load('storage/exports/'. $fName)->get();
      //
      // foreach($rows as $key => $row){
      //   $arr[$key][0] = $row['lat'];
      //   $arr[$key][1] = $row['long'];
      // }
      //
      // $length = sizeof($arr);
      // $distance = 0;
      // $wofdistance =0;
      // $service = new DirectionService();
      // for($i =0; $i<$length-1; $i++){
      //   $temp=$service->distance($arr[$i][0], $arr[$i][1], $arr[$i+1][0], $arr[$i+1][1]);
      //   if($temp>30){
      //     $distance+=$temp;
      //   }
      //   $wofdistance += $temp;
      // }
      //
      // $arr = [$distance, $wofdistance];
      //
      // return $arr;
      //
      $devices =  Device::where('version', '>=', "3.7.5")->get();

      dd($devices);
      // $service = new DirectionService();
      // $temp=$service->distance(23.821856, 90.43454, 23.80825, 90.430573);


      //return $temp;
    }
}
