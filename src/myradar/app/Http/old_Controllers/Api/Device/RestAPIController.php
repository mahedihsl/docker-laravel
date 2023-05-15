<?php

namespace App\Http\Controllers\Api\Device;

use App\Entities\Device;
use App\Entities\User;
use App\Entities\UserLogin;
use App\Entities\Car;
use App\Entities\Position;
use App\Entities\CarStatusLog;
use App\Entities\UserLoginHistory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use MongoDB\Collection;
use App\Http\Controllers\Sms\SMSController;
use GuzzleHttp;
use Carbon\Carbon;
use Exeption;
use Auth;
use Validator;
use Illuminate\Routing\Route;
use Mail;
use Hash;
use Event;
use App\Events\getEngineStatus;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Stream\Stream;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7;
use App\Mail\setNewPasswordMail;
use App\Helpers\AppHelper;
use Illuminate\Support\Facades\DB;
use App\Service\Microservice\SmsMicroservice;
use App\Service\Microservice\UserMicroservice;

class RestAPIController extends Controller
{
    public $successStatus = 200;
    private $client;
    private $key;
    private $smsService;

    public function __construct()
    {
        $this->SMS = new SMSController();
        $this->user = new User();
        $this->AppHelper = new AppHelper();
        $this->smsService = new SmsMicroservice();
        //$this->CarStatusLog = new CarStatusLog();
    }

    public function getUserLocation(Request $request)
    {
        $device_id = $request->get('device_id');
        // $device = Device::find($request->get('device_id'));
        $date = $request->get('date');
        $auth_key = $request->get('login_token');

        $device = Device::with(['car'])->find($device_id);

        // TODO: Special exception for Customer Shakil Ahmed
        if (!$device->car->status || $device_id == '5d00b7776237460eb949530d') {
            return response()->json([
                'status' => 1,
                'message' => 'Success',
                'data' => collect([]),
            ]);
        }

        if (is_null($device_id)) {
            return response()->json([
                'status' => 0,
                'message' => 'Please Provide Device'
            ]);
        } elseif (is_null($request->get('from_hr')) || is_null($request->get('from_mn')) || is_null($request->get('from_am'))
            || is_null($request->get('to_hr')) || is_null($request->get('to_mn')) || is_null($request->get('to_am'))) {
            return response()->json([
                'status' => 0,
                'message' => 'Please Provide required params'
            ]);
        } elseif (strlen($request->get('from_mn')) <= 1 || strlen($request->get('to_mn')) <= 1) {
            return response()->json([
                'status' => 0,
                'message' => 'Please Provide Double Digit Minutes'
            ]);
        } else {
            $from_t = $request->get('from_hr') . ':' . $request->get('from_mn') . ' ' . $request->get('from_am');
            $to_t = $request->get('to_hr') . ':' . $request->get('to_mn') . ' ' . $request->get('to_am');

            $from_t = $request->get('date') . ' ' . $from_t;
            $to_t = $request->get('date') . ' ' . $to_t;

            $from = Carbon::createFromFormat('m/d/Y h:i A', $from_t);
            $to = Carbon::createFromFormat('m/d/Y h:i A', $to_t);

            $demoDeviceId = '5f63fbca32ebd87dc663002a';
            if ($device_id == $demoDeviceId) {
                /**
                 * If this is Demo User's device, then return only 2 hours recording
                 */
                $to = $from->copy()->addHours(2);
            }

            $st_time = new \MongoDB\BSON\UTCDateTime($from->timestamp * 1000);
            $en_time = new \MongoDB\BSON\UTCDateTime($to->timestamp * 1000);

            $query = [
                '$and' => [
                    ['device_id' => ['$eq' => $device_id]],
                    ['when' => ['$gt' => $st_time]],
                    ['when' => ['$lt' => $en_time]],
                ]
            ];
            $options = [
                'sort' => ['when' => 1],
                'projection' => [
                    'when' => true,
                    'lat' => true,
                    'lng' => true,
                    'speed' => true,
                    'deleted_at' => true,
                ]
            ];

            $items = Position::raw(function ($collection) use ($query, $options) {
                return $collection->find($query, $options);
            });

            $pos = $items->filter(function ($v) {
                return is_null($v->deleted_at);
            })
                ->values()
                ->map(function ($item) {
                    $item->lat = strval($item->lat);
                    $item->lng = strval($item->lng);
                    $item->speed = floor($item->speed);
                    return $item;
                });

//            if ($device_id == '60d45fca95cbdc13e1d2a6c0') {
                $len = $pos->count();
                if ($len > 1) {
                    for ($i = 0; $i < $len - 1; $i++) {
                        if (!$pos[$i]->speed) {
                            $temp = floor($pos[$i]->findSpeed($pos[$i + 1]));
                            $pos[$i]->speed = $temp < 200 ? $temp : 0;
                        }
                    }
                    $pos[$len - 1]->speed = 0;
                }
//            }

            return response()->json([
                'status' => 1,
                'message' => 'Success',
                'data' => $pos
            ]);
        }
    }


    /**
     * login api
     *all to undefined method Illuminate\Routing\Route::dispatch()
     * @return \Illuminate\Http\Response
     */


    public function isAuthorized($auth_key)
    {
        $user_login = UserLogin::where('auth_key', $auth_key)->first();
        if (!is_null($user_login)) {
            return 1;
        } else {
            return 0;
        }
    }

    public function isMobileDev()
    {
        if (isset($_SERVER['HTTP_USER_AGENT']) and !empty($_SERVER['HTTP_USER_AGENT'])) {
            $user_ag = $_SERVER['HTTP_USER_AGENT'];
            if (preg_match('/(Mobile|Android|Tablet|GoBrowser|[0-9]x[0-9]*|uZardWeb\/|Mini|Doris\/|Skyfire\/|iPhone|Fennec\/|Maemo|Iris\/|CLDC\-|Mobi\/)/uis', $user_ag)) {
                return 1;
            } else {
                return 0;
            };
        } else {
            return 0;
        };
    }

    public function getState($user_id)
    {
        $Device = User::findorFail($user_id)->devices()->first();

        $data = ['lock_status' => $Device->lock_status,
            'engine_status' => $Device->engine_status];
        return $data;
    }

    public function getLocknEngineState(Request $request)
    {
        // 0 means unlocked 1->locked
        // 0 means engine off 1 means on
        try {
            $device_id = $request->get('device_id');
            $car_id = $request->get('car_id');

            $Device = null;
            $status = true;
            if ($car_id) {
                $Device = Car::find($car_id);
                $status = $Device->status;
                $Device = $Device->device;
            } elseif ($device_id) {
                $Device = Device::with(['car'])->find($device_id);
                $status = $Device->car->status;
            }
            if (!is_null($Device) && $status) {
                return response()->json([
                    'status' => 1,
                    'data' => [
                        'lock_status' => $Device->lock_status,
                        'engine_status' => $Device->engine_status]
                ]);
            }
        } catch (\Exception $th) {
            //throw $th;
        }
        return response()->json([
            'status' => 0,
            'message' => 'Device Not Found'
        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            // 'device_token'=>'required',
            'password' => 'required',
            // 'device_type'=>'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 2, 'message' => $validator->errors()], 401);
        }

        if (Auth::attempt(['email' => request('username'), 'password' => request('password')]) ||

            Auth::attempt(['phone' => request('username'), 'password' => request('password')])

        ) {
            // $device_token = $request->get('device_token');
            // $device_type = intval($request->get('device_type'));//0 =Android 1=ios ..
            // $input['device_token'] = $device_token;
            // $input ['auth_key'] = sha1($input['device_token'].Carbon::now());
            // $input['user_id'] = Auth::user()->id;
            // $input['device_type'] = isset($device_type)?$device_type:null;

            // $existLogin = UserLogin::where('device_token', $device_token)->first();
            $user_info = Auth::user();
            $car_info = $this->AppHelper->getUserCarInfo($user_info->id);

            // $LoginHistory = UserLoginHistory::where('user_id',$user_info->id)->first();

            // $this->AppHelper->login_history_update($LoginHistory,$user_info->id,$device_type,$login=true,$request='login');

            if ($user_info->type != 4 && $user_info->customer_type != 1) {
                return response()->json(
                    [
                        'status' => 0,
                        'message' => 'Only Private Users are allowed to Use'],
                    401
                );
            }
            // $UserLogins =  UserLogin::create($input);
            return response()->json([
                'status' => 1,
                'message' => 'User Login Token Generated',
                'data' => [
                    'login_token' => '', //$UserLogins->auth_key
                    'user' => $user_info,
                    'max_fence' => config('car.fence.limit'),
                    'fence_count' => 0, //$user_info->fences()->count()
                    'api_token' => $user_info->api_token,
                    'device' => $user_info->devices()->first(['id']),
                    'car_color' => '',
                    'car' => $car_info
                ]
            ], 200);
        } else {
            return response()->json(['status' => 0, 'message' => 'Login Failed,UserName or Password is incorrect'], 401);
        }
    }

    public function logout(Request $request)
    {
        $device_token = $request->get('device_token');
        $user_id = $request->get('user_id');
        $device_type = $request->get('device_type');
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'device_token' => 'required',
            'device_type' => 'required|between:0,1'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 2, 'message' => $validator->errors()], 401);
        }
        $existLogin = UserLogin::where('device_token', $request->get('device_token'))
            ->get()->each(function ($item) use ($user_id) {
                $item->delete();
            });

        $LoginHistory = UserLoginHistory::where('user_id', $user_id)->first();
        $this->AppHelper->login_history_update($LoginHistory, $user_id, $device_type, $login = false, $request = "logout");
        return response()->json(['status' => 1, 'message' => 'Logout Successfull'], 200);
    }


    public function sendVerificationCode(Request $request)
    {
        $username = $request->get('username');


        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            //email
            $User = User::where('email', $username)->first();
            $is_email = 1;
            $is_phone = 0;
        } elseif (is_numeric($username)) {
            //phone
            $User = User::where('phone', $username)->first();
            $is_phone = 1;
            $is_email = 0;
        } else {
            return response()->json(['status' => 0, 'message' => 'Invalid Username'], 401);
        }

        if (is_null($User)) {
            return response()->json(['status' => 0, 'message' => 'User not Exist'], 200);
        }

        if ($is_email == 1 || $is_phone == 1) {

            //now generate verification code and sent it to user's number

            $User->verification_code = $this->user->generateVerificationCode();
            $User->verification_code_expires = Carbon::now()->addHours(24);
            $User->is_verification_code_valid = true;
            $url = route('setNewPassword');

            // $msg =  '<button href="'.$url.'" type="button" class="btn btn-success">Left</button>';

            if ($User->save() && $is_phone == true) {
                //send sms
                //  $url = 'www.facebook.com';
                $content = "Your Password Reset Code is " . $User->verification_code . '. Click the link to set new password ' . $url;
                try {
                    // $sms_sent = $this->SMS->sendSMS($User->phone, $content);
                    $this->smsService->send($User->phone, $content);
                    return response()->json(['status' => 1, 'message' => 'Password Reset Code sent to your Phone'], 200);
                } catch (\Exception $e) {
                    return response()->json(['status' => 0, 'message' => 'SMS sending failed'], 200);
                }
            } elseif ($User->save() && $is_email == true) {
                //send Email
                $content = [];
                $content['text'] = "Your Password Reset Code is " . $User->verification_code;
                $content['link'] = $url;

                Mail::to($User->email)
                    //->cc($moreUsers)
                    //->bcc($evenMoreUsers)

                    ->send(new setNewPasswordMail($content));
                // ->queue(new setNewPasswordMail($content));
                return response()->json(['status' => 1, 'message' => 'Password Reset Code sent to your E-mail'], 200);
            }
        }
    }


    public function checkVerificationCode(Request $request)
    {
        $code = $request->get('code');
        $username = $request->get('username');

        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'username' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 2, 'message' => $validator->errors()], 401);
        }

        $User = User::where('verification_code', $code)->first();

        if (!is_null($User)) {
            return $this->isValidCode($User);
        }
        return response()->json(['status' => 0, 'message' => "Wrong Verfication Code"], 200);
    }


    public function changePassword(Request $request)
    {
        $username = $request->get('username');
        $code = $request->get('code');
        $password = $request->get('password');

        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'username' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 2, 'message' => $validator->errors()], 401);
        }

        $User = User::where('verification_code', $code)->first();

        if (!is_null($User)) {
            return $this->isValidCode($User, $password);
        }
        return response()->json(['status' => 0, 'message' => "Wrong Verfication Code"], 200);
    }


    public function isValidCode($User, $password = null)
    {
        if (is_null($User)) {
            return response()->json(['status' => 0, 'message' => 'Invalid Code/User Not found'], 200);
        }
        if ($User->verification_code_expires->gt(Carbon::now()) && $User->is_verification_code_valid == true) {
            if (isset($password)) { //change password
                $User->password = bcrypt($password);
                $User->is_verification_code_valid = false;
                if ($User->save()) {
                    return response()->json(['status' => 1, 'message' => 'Password Updated'], 200);
                }
                return response()->json(['status' => 0, 'message' => 'Changing password failed'], 200);
            }

            return response()->json(['status' => 1, 'message' => 'Verification Code is valid.Please Proceed'], 200);
        } else {
            if ($User->is_verification_code_valid == false) {
                return response()->json(['status' => 0, 'message' => 'Verification Code Already Used Once .Please Request for another one'], 200);
            }
            return response()->json(['status' => 0, 'message' => 'Verification Code Expired .Please Request for another one'], 200);
        }
    }


    public function resetPassword(Request $request)
    {
        $user_id = $request->get('user_id');
        $old_pass = $request->get('old_password');
        $new_pass = $request->get('new_password');

        $User = User::find($user_id);

        if (is_null($User)) {
            return response()->json(['status' => 0, 'message' => 'User Not Found!'], 200);
        }

        if ($User->email == 'demo@myradar.com') {
            return response()->json(['status' => 0, 'message' => 'You can not change password of this account!'], 200);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'new_password' => 'required',
            'old_password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 2, 'message' => $validator->errors()], 401);
        }

        if (Hash::check($old_pass, $User->password)) {
            // The passwords match...
            $User->password = bcrypt($new_pass);
            $User->save();

            $userService = new UserMicroservice();
            $userService->logPasswordChange($User->id);

            return response()->json(['status' => 1, 'message' => 'Password updated.Please Login'], 200);
        }
        return response()->json(['status' => 0, 'message' => 'Old password did not match! please provide correct one'], 200);
    }

    public function updateCarDates(Request $request)
    {
        $user_id = $request->get('user_id');
        $User = User::find($user_id);

        $reg_date = $request->get('reg_date');
        $tax_date = $request->get('tax_date');
        $insurance_date = $request->get('insurance_date');
        $fitness_date = $request->get('fitness_date');

        $all_dates = ['reg_date' => $reg_date, 'tax_date' => $tax_date, 'insurance_date' => $insurance_date, 'fitness_date' => $fitness_date];

        $all_dates_save_array = ['reg_date' => null, 'tax_date' => null, 'insurance_date' => null, 'fitness_date' => null];


        if (is_null($reg_date) && is_null($tax_date) && is_null($insurance_date) && is_null($fitness_date)) {
            return response()->json(['status' => 0, 'message' => "Please Provide at least one date"], 200);
        }

        if (!is_null($User)) {
            $car_info = $User->cars()->first();
            if (is_null($car_info)) {
                return response()->json(['status' => 0, 'message' => "car not found for this user"], 200);
            }
        } else {
            return response()->json(['status' => 0, 'message' => "user not found"], 200);
        }
        $err = 0;
        foreach ($all_dates as $name => $value):
            if (!is_null($value)) {
                try {
                    $all_dates_save_array[$name] = Carbon::createFromFormat('d/m/Y', $value)->toDateString();
                } catch (\Exception $ex) {
                    $err = 1;
                    return response()->json(['status' => 0, 'message' => $ex->getMessage()], 200);
                }
            }
        endforeach;
        if ($err != 1) {
            foreach ($all_dates_save_array as $name => $date) {
                if (!is_null($date)) {
                    $car_info->$name = $date;
                    $car_info->save();
                }
            }
        }

        return response()
            ->json(['status' => 1,
                'message' => 'Updated',
                'data' => [
                    'reg_date' => $car_info->reg_date ? $car_info->reg_date->timestamp : null,
                    'tax_date' => $car_info->tax_date ? $car_info->tax_date->timestamp : null,
                    'insurance_date' => $car_info->insurance_date ? $car_info->insurance_date->timestamp : null,
                    'fitness_date' => $car_info->fitness_date ? $car_info->fitness_date->timestamp : null

                ]
            ], 200);
    }

    public function getCarDates(Request $request)
    {
        $user_id = $request->get('user_id');
        $User = User::find($user_id);
        return response()
            ->json(['status' => 1,
                'message' => 'Car Dates',
                'data' => [
                    'reg_date' => $User->cars()->first()->reg_date ? $User->cars()->first()->reg_date->timestamp : null,
                    'tax_date' => $User->cars()->first()->tax_date ? $User->cars()->first()->tax_date->timestamp : null,
                    'fitness_date' => $User->cars()->first()->fitness_date ? $User->cars()->first()->fitness_date->timestamp : null,
                    'insurance_date' => $User->cars()->first()->insurance_date ? $User->cars()->first()->insurance_date->timestamp : null,

                ]
            ], 200);
    }

    public function updateUserInfo(Request $request)
    {
        $phone = $request->get('phone');
        $nid = $request->get('nid');
        $name = $request->get('name');
        $user_id = $request->get('user_id');
        $note = $request->get('note');
        $User = User::find($user_id);


        if (is_null($User)) {
            return response()->json(['status' => 0, 'message' => "user not found"], 200);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'nid' => 'numeric',
            'phone' => 'bd_phone'

        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 2, 'message' => $validator->errors()], 401);
        }
        $fields = ['phone' => $phone, 'nid' => $nid, 'name' => $name, 'note' => $note];

        foreach ($fields as $field => $value):
            if (!is_null($value)):
                $User->$field = $value;
            endif;
        endforeach;

        if ($User->save()) {
            return response()->json(['status' => 1, 'message' => "Success", 'data' => $User], 200);
        }
    }

}
