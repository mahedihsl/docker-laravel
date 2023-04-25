<?php

namespace App\Http\Controllers\Api\Device;

use App\Entities\Device;
use App\Entities\User;
use App\Entities\UserLogin;
use App\Entities\Car;
use App\Entities\Position;
use App\Entities\Subscription;
use App\Entities\Service;
use App\Entities\ServiceLog;
use App\Entities\FuelHistory;
use App\Entities\GasHistory;
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

class HistoryAPIController extends Controller
{
    // TODO: Deprecated controller, remove this entire controller
    public function fuel_histories(Request $request)
    {
        $user_id = $request->get('user_id');
        $device_id = $request->get('device_id');
        $from = $request->get('from');
        $to = $request->get('to');

        if (isset($user_id)) {//web site
            $Device= User::findorFail($user_id)->devices()->first();
        } else { //mobile device
            $Device = Device::findorFail($device_id);
        }

        $from_date = Carbon::createFromFormat('Y-m-d', $from);
        $to_date = Carbon::createFromFormat('Y-m-d', $to);

        $fuel_histories = FuelHistory::where('device_id', $Device->id)
           ->where('when', '<', $to_date)
           ->where('when', '>', $from_date)
           ->select('when', 'value')
           ->orderBy('when', 'asc')->get();

        $data = [];

        foreach ($fuel_histories as $key=>$value):
       $data[$value->when->toDateTimeString()][] = $value->value;
        endforeach;


        $res =   $this->getMaxDateTime($data);
        $result = [];

        foreach ($res as $key=>$val):
         $result[Carbon::createFromFormat('Y-m-d H:i:s', $key)->toDateString()]= $val[0];
        endforeach;

        return response()->json([
        'status'=>1,
        'data'=>$result,
        'message'=>"Fuel History"
      ]);
    }



    public function gas_histories(Request $request)
    {
        $user_id = $request->get('user_id');
        $device_id = $request->get('device_id');
        $from = $request->get('from');
        $to = $request->get('to');

        if (isset($user_id)) {//web site
            $Device= User::findorFail($user_id)->devices()->first();
        } else { //mobile device
            $Device = Device::findorFail($device_id);
        }

        $from_date = Carbon::createFromFormat('Y-m-d', $from);
        $to_date = Carbon::createFromFormat('Y-m-d', $to);

        $gas_histories = GasHistory::where('device_id', $Device->id)
           ->where('when', '<', $to_date)
           ->where('when', '>', $from_date)
           ->select('when', 'value')
           ->orderBy('when', 'asc')->get();

        $data = [];

        foreach ($gas_histories as $key=>$value):
       $data[$value->when->toDateTimeString()][] = $this->getCalibratedGasValue($value->value);
        endforeach;


        $res =   $this->getMaxDateTime($data);
        $result = [];


        foreach ($res as $key=>$val):

      $result[Carbon::createFromFormat('Y-m-d H:i:s', $key)->toDateString()]= (int)$val[0];
        endforeach;

        return response()->json([
      'status'=>1,
      'data'=>$result,
      'message'=>"Gas History"
    ]);
    }


    private function getMaxDateTime(array $data)
    {
        $dates =[];
        $times = [];
        $result = [];

        foreach ($data as $key => $val) {
            $dt = explode(' ', $key);
            if (!in_array($dt[0], $dates)) {
                $dates[] = $dt[0];
            }
            if (!isset($times[$dt[0]]) || strtotime($times[$dt[0]]) < strtotime($dt[1])) {
                $times[$dt[0]] = $dt[1];
            }
        }

        foreach ($dates as $val) {
            $key = "{$val} {$times[$val]}";
            $result[$key] = $data[$key];
        }

        return $result;
    }


    private function getCalibratedGasValue($value)
    {
        if ($value<=99) {
            return 4;
        } elseif ($value>99 && $value<=151) {
            return 3;
        } elseif ($value>151 && $value<=203) {
            return 2;
        } elseif ($value>203 && $value<=255) {
            return 1;
        } elseif ($value>255) {
            return 0;
        }
    }

    public function getFuelGasLevel(Request $request)
    {
        $user_id = $request->get('user_id');
        $device_id = $request->get('device_id');
        if (isset($user_id)) {//web site
            $Device= User::findorFail($user_id)->devices()->first();
        } else { //mobile device
            $Device = Device::findorFail($device_id);
        }

        $fuel_level = FuelHistory::where('device_id', $Device->id)->orderBy('created_at', 'desc')->first();
        $gas_level = GasHistory::where('device_id', $Device->id)->orderBy('created_at', 'desc')->first();

        $temp = null;
        if (!is_null($fuel_level)) {
            $temp = 100 - ($fuel_level->value / 5);
            $temp = intval(max(0, floor($temp)));
        }

        return response()->json([
      'status'=>1,
      'data'=>[
        'fuel'=>$temp,
        'gas'=>!is_null($gas_level)?$this->getCalibratedGasValue($gas_level->value):null,
      ]
    ]);
    }
}

?>
