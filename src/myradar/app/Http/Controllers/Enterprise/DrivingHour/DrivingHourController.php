<?php

namespace App\Http\Controllers\Enterprise\DrivingHour;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Entities\Car;
use App\Entities\User;
use App\Entities\Driver;
use App\Entities\Mileage;
use App\Entities\CarStatusLog;
use App\Entities\Position;
use App\Entities\Device;

use App\Entities\DrivingHour;
use Carbon\Carbon;
use App\Contract\Repositories\DrivingHourRepository;

use App\Criteria\CarIdCriteria;
use App\Criteria\CarOwnerNameCriteria;
use App\Criteria\CarOwnerPhoneCriteria;
use App\Criteria\CarRegNoCriteria;
use App\Criteria\DateRangeCriteria;
use App\Criteria\LastUpdatedCriteria;

class DrivingHourController extends Controller
{
    public function __construct(DrivingHourRepository $repository)
    {
        $this->repository = $repository;
    }

    public function show(Request $request)
    {
        return view('enterprise.driving_hour.show')->with([
            'user' => $this->getWebUser(),
            'driving_hour'=>[]
        ]);
    }

    public function records(Request $request, $carId, $days)
    {
        $this->repository->pushCriteria(new DateRangeCriteria($days - 1, 0));
        $this->repository->pushCriteria(new CarIdCriteria($carId));
        $this->repository->pushCriteria(new LastUpdatedCriteria());
        return response()->ok($this->repository->all());
    }

    public function result(Request $request)
    {
        $car_reg_no = $request->get('car_reg_no');
        $owner_name = $request->get('owner_name');
        $owner_phone = $request->get('owner_phone');
        $driver_name = $request->get('driver_name');

        $customer_ids =User::orWhere('phone', 'like', '%'.$owner_phone.'%')
                      ->orWhere('name', 'like', '%'.$owner_name.'%')
                      ->get()->map(function ($item) {
                          return $item->id;
                      });

        $driver_car_ids = Driver::where('driver_name', 'like', '%'.$driver_name.'%')
                       ->get()->map(function ($item) {
                           return $item->car_id;
                       });
        $data = Car::orWhere('reg_no', 'like', '%'.$car_reg_no.'%')
                   ->orWhereIn('user_id', $customer_ids)
                   ->orWhereIn('_id', $driver_car_ids)
           ->get()->map(function ($item) {
               $arr = [];
               $arr['car_id'] = isset($item->id)?$item->id:"";
               $arr['car_no'] = isset($item->reg_no)?$item->reg_no:"";
               $arr['driver_name'] = isset($item->driver->driver_name)?$item->driver->driver_name:'';
               $arr['driver_phone'] = isset($item->driver->phone)?$item->driver->phone:'';
               $arr['owner_name'] = isset($item->user->name)?$item->user->name:"";
               $arr['owner_phone'] = isset($item->user->phone)?$item->user->phone:"";
               $arr['region'] = null;
               $arr['total_driving_hour'] =  !is_null($item->getMonthlyDrivingHour())?$item->getMonthlyDrivingHour():""; //km
               return $arr;
           });

        return view('enterprise.driving_hour.show')->with([
                   'user' => $this->getWebUser(),
                   'driving_hour'=>$data,
                   'car_reg_no'=>$car_reg_no,
                   'owner_name'=>$owner_name,
                   'owner_phone'=>$owner_phone,
                   'driver_name'=>$driver_name,

               ]);
    }
}
