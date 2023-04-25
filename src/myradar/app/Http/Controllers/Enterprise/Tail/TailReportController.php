<?php
namespace App\Http\Controllers\Enterprise\Tail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\MileageRepository;
use App\Criteria\CarRegNoCriteria;
use App\Criteria\CarOwnerNameCriteria;
use App\Criteria\CarOwnerPhoneCriteria;
use App\Criteria\CarIdCriteria;
use App\Entities\Car;
use App\Entities\User;
use App\Entities\Driver;
use App\Entities\Mileage;
use App\Entities\DrivingHour;
use Carbon\Carbon;
use Auth;

class TailReportController extends Controller
{

  public function show(Request $request)
  {
    return view('enterprise.tail.show')->with([
        'user' => $this->getWebUser(),
        'report'=>[]
    ]);

  }

  public function result(Request $request)
  {
   $report_type = $request->get('report_type');
   $comparison_type =   $request->get('comparison_value');
   $value =   $request->get('filter_value');
   //"1">Mileage
   //"2">Driving Hour
   //"3">Duty Hour
   //"4">Fuel Consumption
   //"5">Mileage Per Litre
   //"6">Mileage per 100 tk
   $cars = Car::where('user_id',Auth::user()->id)
              ->where('ownership_type',2);   //2 for enterprise customers

   if($report_type==1)
     {
       $result = $cars->get()->map(function ($item) {
                   $arr = [];
                   $arr['car_id'] = isset($item->id)?$item->id:"";
                   $arr['car_no'] = isset($item->reg_no)?$item->reg_no:"";
                   $arr['driver_name'] = isset($item->driver->driver_name)?$item->driver->driver_name:'';
                   $arr['driver_phone'] = isset($item->driver->phone)?$item->driver->phone:'';
                   $arr['owner_name'] = isset($item->user->name)?$item->user->name:"";
                   $arr['owner_phone'] = isset($item->user->phone)?$item->user->phone:"";
                   $arr['region'] = null;
                   $arr['mileage'] =  !is_null($item->getMonthlyMileage()/1000)?$item->getMonthlyMileage()/1000:""; //km
                   return $arr;
               });

    }
  elseif($report_type==2)
    {
      $result = $cars->get()->map(function ($item) {
                  $arr = [];
                  $arr['car_id'] = isset($item->id)?$item->id:"";
                  $arr['car_no'] = isset($item->reg_no)?$item->reg_no:"";
                  $arr['driver_name'] = isset($item->driver->driver_name)?$item->driver->driver_name:'';
                  $arr['driver_phone'] = isset($item->driver->phone)?$item->driver->phone:'';
                  $arr['owner_name'] = isset($item->user->name)?$item->user->name:"";
                  $arr['owner_phone'] = isset($item->user->phone)?$item->user->phone:"";
                  $arr['region'] = null;
                  $arr['driving_hour'] =  !is_null($item->getMonthlyDrivingHour())?$item->getMonthlyDrivingHour():""; //km
                  return $arr;
              });


    }

    return view('enterprise.tail.show')->with([
               'user' => $this->getWebUser(),
               'data'=>$result,
           ]);
  }
}
