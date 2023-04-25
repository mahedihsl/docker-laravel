<?php

namespace App\Http\Controllers\Api\Device;

use App\Entities\Device;
use App\Entities\Imsi;
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
use App\Http\Controllers\Car\CarApiController;
use Event;
use App\Events\getEngineStatus;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Stream\Stream;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7;
use App\Mail\setNewPasswordMail;
use App\Helpers\AppHelper;

class ModeController extends Controller
{
    public function __construct()
    {
        $this->SMS = new SMSController();
        $this->user = new User();
    }
    public function getMode(Request $request)
    {
        // 0 means unlocked 1->locked
        $device_id = $request->get('device_id');
        $validator = Validator::make($request->all(), [
          'device_id'=>'required',
         ]);
        if ($validator->fails()) {
            return response()->json(['status'=>2,'message'=>$validator->errors()], 401);
        }
        $Device = Device::findorFail($device_id);
        if (!is_null($Device)) {
            return response()->json(['status'=>1,'data'=>['lock_status'=>$Device->lock_status]]);
        }
        return response()->json([
        'status'=>0,
        'message'=>'Device Not Found'
      ]);
    }

    public function getEngineStatus(Request $request)
    {
        // 0 means off
        //1 means on
        $device_id = $request->get('device_id');
        $validator = Validator::make($request->all(), [
        'device_id'=>'required',
       ]);
        if ($validator->fails()) {
            return response()->json(['status'=>2,'message'=>$validator->errors()], 401);
        }
        $Device = Device::findorFail($device_id);
        if (!is_null($Device)) {
            return response()->json(['status'=>1,'data'=>['engine_status'=>$Device->engine_status]]);
        }
        return response()->json(['status'=>0,'message'=>'Device Not Found']);
    }

    public function setMode(Request $request)
    {
        $lock_status = $request->get('lock_status');
        $device_id = $request->get('device_id');

        $validator = Validator::make($request->all(), [
         'lock_status' => 'required',
         'device_id'=>'required'
     ]);
        if ($validator->fails()) {
            return response()->json(['status'=>2,'message'=>$validator->errors()], 401);
        }
        $device = Device::find($device_id);

        if (is_null($device)) {
            return response()->json(['status'=>0,'message'=>'device not found'], 200);
        }
        if ($lock_status==0) {
            $device->lock_status=0;
            $device->lock_status_when=Carbon::now();
            $device->save();
            $statusText = "Car Unlocked";
            return response()->json(['status'=>1,'message'=>$statusText,'data'=>['lock_status'=>$device->lock_status]], 200);
        } elseif ($lock_status==1) {
            $device->lock_status=1;
            $device->lock_status_when=Carbon::now();
            $device->save();

            if ($device->engine_status==0) {
                return response()->json(['status'=>1,'message'=>'Car Locked','data'=>['lock_status'=>$device->lock_status]], 200);
            } elseif ($device->engine_status==1) {
                $device_imsi = $device->toArray()['imsi'];
                $phone = Imsi::where('imsi', (String)$device_imsi)->first();

                if (is_null($phone)) {
                    return response()->json(['status' => 0,'data'=>['lock_status'=>$device->lock_status],'message' => 'Device Phone number not Assigned Yet']);
                }

                $timeout =600;//in second //in minutes 10
                $text = "ENGINE OFF";
                $timestamp =Carbon::now()->timestamp;
                $content = $text.','.$timestamp.','.$timeout;
                $sms_sent=$this->SMS->sendSMS($phone->phone, $content);

                if ($sms_sent==1) {
                    $device = Device::find($device_id);
                    $statusText = "Car Locked";
                    return response()->json(['status'=>1,'message'=>$statusText,'data'=>['lock_status'=>$device->lock_status]], 200);
                } else {
                    return response()->json(['status'=>1,'message'=>"Sms Sending Failed",'data'=>['lock_status'=>$device->lock_status]], 200);
                }
            }
        }
    }
}
