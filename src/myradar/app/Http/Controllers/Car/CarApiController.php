<?php

namespace App\Http\Controllers\Car;

use App\Entities\Car;
use App\Entities\User;
use App\Entities\Device;
use App\Entities\Manufacturer;
use App\Http\Requests\CreateCar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Auth;
class CarApiController extends Controller
{
    public function __construct()
    {
        //  $this->middleware('auth');
    }

    public function makers(Request $request)
    {
        $makers = Manufacturer::all()->map(function ($item) {
            return $item->transform();
        });
        return response()->json($makers);
    }

    public function colors()
    {
        return response()->json([

            ['id' =>Car::$COLOR_BLACK, 'name'=>'Black'],
            ['id' =>Car::$COLOR_WHITE, 'name'=>'White'],
            ['id' =>Car::$COLOR_RED, 'name'=>'Red'],
            ['id' =>Car::$COLOR_ASH, 'name'=>'Ash'],
            ['id' =>Car::$COLOR_BLUE, 'name'=>'Blue'],

        ]);
    }
    public function getColorName($key=null)
    {
        $colors= [Car::$COLOR_BLACK=>'Black',
               Car::$COLOR_WHITE =>'White',
               Car::$COLOR_RED=>'Red',
               Car::$COLOR_ASH =>'Ash',
               Car::$COLOR_BLUE =>'Blue'];


        return isset($colors[$key]) ? $colors[$key] : null;
    }

    public function fuel()
    {
        return response()->json([
            ['id' =>Car::$FUEL_GAS, 'name'=>'Gas'],
            ['id' =>Car::$FUEL_PETROL, 'name'=>'Petrol'],
            ['id' =>Car::$FUEL_DISEL, 'name'=>'Disel']
        ]);
    }

    public function type()
    {
        return response()->json([
            ['id' =>Car::$TYPE_CAR, 'name'=>'Car'],
            ['id' =>Car::$TYPE_MICRO, 'name'=>'Micro'],
            ['id' =>Car::$TYPE_BIKE, 'name'=>'Bike']
        ]);
    }

    public function services(Request $request)
    {
        return response()->json([
            ['id' => Car::$SERVICE_LATLNG, 'name' => 'LatLng'],
            ['id' => Car::$SERVICE_FUEL, 'name' => 'Fuel'],
            ['id' => Car::$SERVICE_GAS, 'name' => 'Gas'],
            ['id' => Car::$SERVICE_LOCK, 'name' => 'Lock'],
            ['id' => Car::$SERVICE_SPEED, 'name' => 'Speed'],
            ['id' => Car::$SERVICE_MILEAGE, 'name' => 'Mileage'],
        ]);
    }

    public function add(CreateCar $request)
    {
        if ($request->get('reg_date') != '') {
            $reg_date = Carbon::createFromFormat('m/d/Y', $request->get('reg_date'));
            $reg_date->hour=0;
            $reg_date->minute=0;
            $reg_date->second=0;
        } else {
            $reg_date = null;
        }

        if ($request->get('tax_date') != '') {
            $tax_date = Carbon::createFromFormat('m/d/Y', $request->get('tax_date'));
            $tax_date->hour=0;
            $tax_date->minute=0;
            $tax_date->second=0;
        } else {
            $tax_date = null;
        }

        if ($request->get('fitness_date') != '') {
            $fitness_date = Carbon::createFromFormat('m/d/Y', $request->get('fitness_date'));
            $fitness_date->hour=0;
            $fitness_date->minute=0;
            $fitness_date->second=0;
        } else {
            $fitness_date = null;
        }

        if ($request->get('insurance_date') != '') {
            $insurance_date = Carbon::createFromFormat('m/d/Y', $request->get('insurance_date'));
            $insurance_date->hour=0;
            $insurance_date->minute=0;
            $insurance_date->second=0;
        } else {
            $insurance_date = null;
        }



        $car = Car::create([
            'name' => $request->get('name'),
            'manufacturer_id' => $request->get('maker'),
            'model' => $request->get('model'),
            'reg_no' => $request->get('reg_no'),
            'chesis_no' => $request->get('chesis_no'),
            'reg_date' =>$reg_date,
            'tax_date' => $tax_date,
            'fitness_date' =>   $fitness_date,
            'insurance_date' => $insurance_date,
            'color' => $request->get('color'),
            'type' => $request->get('type'),
            'fuel_type' => $request->get('fuel'),
            'engine_cc' => $request->get('engine_cc'),
            'cng' => $request->get('cng'),
            'note' => $request->get('note'),
            'user_id'=>$request->get('user_id')
        ]);

        if (! is_null($car)) {
            return response()->json(['car_id'=>$car['_id'],'user_id'=>$car['user_id'],'msg'=>'Car Created']);
        }

        return response()->json(['status'=>0,'msg'=>'Car Creation failed']);
    }

    public function authorizeLockUnlock(Request $request)
    {
        $user_id = Auth::user()->id;
        $car_id = $request->get('car_id');
        $User = User::findorFail($user_id);
        if (Auth::attempt(['email' => $User->email, 'password' => request('password')])||
         Auth::attempt(['phone' => $User->phone, 'password' => request('password')])) {
         return response()->json(['status'=>1,'msg'=>'Authorized']);
        }
        return response()->json(['status'=>2,'msg'=>'Authorization failed'],200);

    }
    public function delete($id)
    {
        $car = Car::find($id);
        $user = $car->user;
        $device_id = $car->device->id;

        if (! is_null($car)) {
            $Device = Device::find($device_id);
            $Device->car_id = '';
            if ($Device->save() &&  $car->delete()) {
                return response()->json([
                'msg'=>'Car Deleted'
              ]);
            }
        }
    }
}
