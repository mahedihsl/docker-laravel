<?php

namespace App\Http\Controllers\Enterprise\Mileage;

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
use Carbon\Carbon;
use Auth;

class MileageController extends Controller
{

  /**
   * @param MileageRepository
   */
    private $repository;

    public function __construct(MileageRepository $repository)
    {
        $this->repository = $repository;
    }


    public function show(Request $request)
    {
        return view('enterprise.mileage.show')->with([
            'user' => $this->getWebUser(),
            'mileage'=>[]
        ]);
    }
    public function records(Request $request)
    {
        $car_reg_no = $request->get('car_reg_no');
        $owner_name = $request->get('owner_name');
        $owner_phone = $request->get('owner_phone');
        $driver_name = $request->get('driver_name');



        //$enterprise_users = User::Where('customer_type', 2);


        $customer_ids =User::orWhere('phone', 'like', '%'.$owner_phone.'%')
                        ->orWhere('name', 'like', '%'.$owner_name.'%')
                        ->get()->map(function ($item) {
                            return $item->id;
                        });


        $driver_car_ids = Driver::where('driver_name', 'like', '%'.$driver_name.'%')
                         ->get()->map(function ($item) {
                             return $item->car_id;
                         });



       $cars = Car::where('user_id',Auth::user()->id)
                  ->where('ownership_type',2);   //2 for enterprise customers

           $mileage = $cars->orWhere('reg_no', 'like', '%'.$car_reg_no.'%')
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
                       $arr['mileage'] =  !is_null($item->getMonthlyMileage()/1000)?$item->getMonthlyMileage()/1000:""; //km

                       return $arr;
                   });



        return view('enterprise.mileage.show')->with([
             'user' => $this->getWebUser(),
             'mileage'=>$mileage,
             'car_reg_no'=>$car_reg_no,
             'owner_name'=>$owner_name,
             'owner_phone'=>$owner_phone,
             'driver_name'=>$driver_name,

         ]);
    }
}
