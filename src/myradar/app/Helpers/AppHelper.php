<?php
namespace App\Helpers;

use App\Entities\Device;
use App\Entities\User;
use App\Entities\UserLogin;
use App\Entities\Car;
use App\Entities\Position;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use MongoDB\Collection;
use App\Http\Controllers\Sms\SMSController;
use App\Entities\UserLoginHistory;
use Carbon\Carbon;
use Auth;
use Validator;
use Illuminate\Routing\Route;
use Mail;
use Event;
use App\Events\getEngineStatus;

class AppHelper
{
    //input : user_id
    //output :cars,
    public function getUserCars($user_id)
    {
        $Cars = Car::where('user_id', $user_id)->get()->map(function ($item) {
            return $item->id;
        })->toArray();
        return $Cars;
    }

    public function getUserCarInfo($user_id, $car_id=null)
    {
        $Cars = Car::where('user_id', $user_id)->first();

        if (empty($Cars)) {
            return [];
        }

        $tax_date = isset($Cars->tax_date)?$Cars->tax_date->timestamp:null;
        $reg_date = isset($Cars->reg_date->timestamp)?$Cars->reg_date->timestamp:null;
        $fitness_date = isset($Cars->fitness_date->timestamp)?$Cars->fitness_date->timestamp:null;
        $insurance_date = isset($Cars->insurance_date->timestamp)?$Cars->insurance_date->timestamp:null;

        $response_array = [
          '_id'=>isset($Cars->id)?$Cars->id:null,
          'model'=>isset($Cars->model)?$Cars->model:null,
          'manufacturer'=>null,
          'tax_date'=>$tax_date,
          'reg_date'=>$reg_date,
          'fitness_date'=>$fitness_date,
          'insurance_date'=>$insurance_date,
        ];

        return $response_array;
    }


    public function removeUnregisteredDeviceLogin(array $device_tokens)
    {
        if (!empty($device_tokens)) {
            $UserLogin = UserLogin::whereIn('device_token', $device_tokens)->get()->each(function ($item) {
                $item->delete();
            });
        }
    }

    public function login_history_update($LoginHistory, $user_id, $device_type, $login, $request)
    {
        if (is_null($LoginHistory)) {
            if ($request=='logout') {
                if ($device_type==UserLoginHistory::$IOS_DEVICE_TYPE) {
                    UserLoginHistory::create([
              'user_id'=>$user_id,
               'ios.logout_at'=>Carbon::now(),
               'ios.is_login'=>$login
            ]);
                } elseif ($device_type==UserLoginHistory::$ANDROID_DEVICE_TYPE) {
                    UserLoginHistory::create([
               'user_id'=>$user_id,
                'android.logout_at'=>Carbon::now(),
                'android.is_login'=>$login
             ]);
                }
            } elseif ($request=='login') {
                if ($device_type==UserLoginHistory::$IOS_DEVICE_TYPE) {
                    UserLoginHistory::create([
                'user_id'=>$user_id,
                 'ios.login_at'=>Carbon::now(),
                 'ios.is_login'=>$login
              ]);
                } elseif ($device_type==UserLoginHistory::$ANDROID_DEVICE_TYPE) {
                    UserLoginHistory::create([
                 'user_id'=>$user_id,
                  'android.login_at'=>Carbon::now(),
                  'android.is_login'=>$login
               ]);
                }
            }
        } else {
            if ($request=='logout') {
                if ($device_type==UserLoginHistory::$IOS_DEVICE_TYPE) {
                    $LoginHistory['ios.logout_at'] = Carbon::now();
                    $LoginHistory['ios.is_login']  =$login;
                    $LoginHistory->save();
                } elseif ($device_type==UserLoginHistory::$ANDROID_DEVICE_TYPE) {
                    $LoginHistory['android.logout_at'] = Carbon::now();
                    $LoginHistory['android.is_login']  =$login;
                    $LoginHistory->save();
                }
            } elseif ($request=='login') {
                if ($device_type==UserLoginHistory::$IOS_DEVICE_TYPE) {
                    $LoginHistory['ios.login_at'] = Carbon::now();
                    $LoginHistory['ios.is_login']  =$login;
                    $LoginHistory->save();
                } elseif ($device_type==UserLoginHistory::$ANDROID_DEVICE_TYPE) {
                    $LoginHistory['android.login_at'] = Carbon::now();
                    $LoginHistory['android.is_login']  =$login;
                    $LoginHistory->save();
                }
            }
        }

        return '1';
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required',
        'c_password' => 'required|same:password'
    ]);

        if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors()], 401);
        }

        $input = $request->only(['name', 'email', 'password']);

        $input['password'] = bcrypt($input['password']);
        $input ['auth_key'] = md5($input['email'].Carbon::now());
        $input ['auth_key_expires'] = Carbon::now()->addHours(6);

        try {
            $user =  User::create($input);
        } catch (\Exception $e) {
            return response()->json(['status'=>0,'message'=>$e->getMessage()], 401);
        }

        $success = "User registered";
        return response()->json(['status'=>0,'message'=>$success], $this->successStatus);
    }
}
