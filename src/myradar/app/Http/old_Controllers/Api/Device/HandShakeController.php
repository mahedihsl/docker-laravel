<?php

namespace App\Http\Controllers\Api\Device;
//use PushNotification;
use App\Entities\DrivingHour;
use App\Entities\Device;
use App\Entities\User;
use App\Entities\Car;
use App\Entities\Imsi;
use App\Entities\Service;
use App\Entities\Position;
use App\Entities\Locator;
use App\Entities\ServiceLog;
use App\Entities\Subscription;
use App\Entities\FuelHistory;
use App\Entities\GasHistory;
use App\Entities\Fence;
use App\Entities\FenceLog;
use App\Entities\CarStatusLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Sms\SMSController;
use App\Http\Controllers\PushNotification\PushNotificationController;
use MongoDB\Collection;
use GuzzleHttp;
use Carbon\Carbon;
use Mail;
use Event;

use App\Events\LatLngReceived;
use App\Events\getLocation;
use App\Events\getEngineStatus;
use App\Events\FuelStatus;
use App\Events\GasStatus;
use App\Events\FenceEnterExit;
use App\Events\FenceCrossEvent;
use App\Events\DateExpirationEvent;
use App\Events\getDrivingHour;
use App\Jobs\ProcessEngineStatusUpdateTasks;

class HandShakeController extends Controller
{
    public function __construct()
    {
      $this->CarStatusLog = new CarStatusLog();
    }

    public function commercialId(Request $request)
    {
        while (true) {
            $com_id = rand(1, 100000);
            $device = Device::where('com_id', $com_id)->first();

            if (is_null($device)) {
                $device = Device::create([
                    'com_id' => $com_id,
                ]);

                return response()->json([
                    'status' => 1,
                    'com_id' => $com_id,
                ]);
            }
        }

        return response()->json([
            'status' => 0,
        ]);
    }

    public function handshake(Request $request)
    {
        $com_id = intval($request->get('com_id'));
        $device = Device::where('com_id', $com_id)->first();

        if (!is_null($device)) {
            $device->update([
                'iccid' => $request->get('iccid'),
                'imei' => $request->get('imei'),
                'type' => intval($request->get('type', '1')),
                'imsi'  =>$request->get('imsi')
            ]);

            return response()->json(['status' => 1,]);
        }

        return response()->json(['status' => 0,]);
    }


    public function receiveServices(Request $request)

        // 1 no is web/app controlled  ->
        // 5 --
        // first 6 event based..
        // then 8 digital freq .
        // last 8  analog freq based

        //15 no is for r&d purpose
    {
        // $data = "146402|0,12,78|2,100|3,value"; //sample payload // 0>data means Error;
        $serviceArray = [];
        $Data =$request->get('ss');
        $geofence_violation = $request->get('gv');
        $engine_status = $request->get('es');
        $distance = $request->get('d');

        foreach (explode('|', $Data) as $key => $value):
            if ($key == 0) {
                $serviceArray['com_id'] = $value;
                $com_id = intval($serviceArray['com_id']);
                $device = Device::where('com_id', $com_id)->first();
            } else {
                $service_id_value = explode(',', $value);
                if ($service_id_value[0] == 0) { //lat_long service
                    //from device we are getting sid ..now find _id

                    $_id = Service::where('sid', intval($service_id_value[0]))->first();

                    $serviceArray['services'][$key]['service_id'] = $_id->id;//service id
                    $serviceArray['services'][$key]['service_value'] =json_encode([$service_id_value[1],$service_id_value[2]]);


                    $carbon_date = Carbon::now();
                    //$carbon_date->addHours(6);
                    if (!is_numeric($service_id_value[2]) || !is_numeric($service_id_value[1])) {
                        return response()->json(['status' => 0, 'msg' => 'Lat Long is not Correct']);
                    }

                    $event_data = ['car_id'=>$device->car->id,'device_id'=>$device->id];

                    event(new getDrivingHour(json_encode($event_data)));

                    $position = Position::create([
                        'lng' => $service_id_value[2],
                        'lat' => $service_id_value[1],
                        'when' => $carbon_date,
                        'device_id' => $device->id,
                    ]);

                    if (! is_null($position)) {

                        event(new LatLngReceived($device, $position));


                    }
                } else {

                       ///fuel service

                    if ($service_id_value[0] == 16) {
                        $_id = Service::where('sid', intval($service_id_value[0]))->first();

                        $serviceArray['services'][$key]['service_id'] = $_id->id;//$service_id_value[0];//service id
                        $serviceArray['services'][$key]['service_value'] = $service_id_value[1];


                        $fuel = FuelHistory::create([
                          'value'  =>intval($service_id_value[1]),
                          'device_id' =>$device->id,
                          'when' => Carbon::now()
                        ]);



                        if (is_null($fuel)) {
                            return 'Failed';
                        } else {
                            $value = ['device_id'=>$device->id,'fuel_status'=>intval($service_id_value[1])];
                            $fuel = json_encode($value);
                            Event::fire(new FuelStatus($fuel));
                        }
                    }

                    //gas
                    if ($service_id_value[0] == 17) {
                        $_id = Service::where('sid', intval($service_id_value[0]))->first();

                        $serviceArray['services'][$key]['service_id'] = $_id->id;//$service_id_value[0];//service id
                        $serviceArray['services'][$key]['service_value'] = $service_id_value[1];


                        $gas = GasHistory::create([
                          'value'  =>intval($service_id_value[1]),
                          'device_id' =>$device->id,
                          'when' => Carbon::now()
                        ]);

                        if (is_null($gas)) {
                            return 'Failed';
                        } else {
                            $value = ['device_id'=>$device->id,'gas_status'=>intval($service_id_value[1])];
                            $gas = json_encode($value);
                            Event::fire(new GasStatus($gas));
                        }
                    }
                }
            }

        endforeach;

        //sending push notification based on GeoFence Entered or exit

        $fence_status_array = [];
        if (isset($geofence_violation)) {
            foreach (explode('|', $geofence_violation) as $key => $value):
          $fence_data = explode(',', $value);
            if (isset($fence_data[0]) && isset($fence_data[1])) {
                $fence = Fence::find($fence_data[0]);
                $flag = boolval($fence_data[1]);
                if ( ! is_null($fence)) {
                    event(new FenceCrossEvent($device, $fence, $flag));
                }
                // $fence_status_array[$fence->id] = $flag;
            }
            endforeach;
            // if (!empty($fence_status_array)) {
            //     //push notification
            //     event(new FenceEnterExit($device, $fence_status_array));
            // }
        }

        // engine status from device (hardware) and setting value in db

        if (isset($engine_status)) {
            if ($engine_status==1) {
                $device->engine_status=1;
                // $device->lock_status = 0;
            } elseif ($engine_status==0) {
                $device->engine_status=0;
            }
            $device->save();
        }

        $alertMsg = "";

        if ($this->checkServices($serviceArray)==0) {
            $alertMsg = 'Service Mismatched ,Some services missing';
        }

        if (isset($serviceArray['com_id'])) {
            $com_id = intval($serviceArray['com_id']);
            $device = Device::where('com_id', $com_id)->first();
            if ($device) {
                $device_id = $device->id;
            } else {
                return response()->json([
               'msg'=>'Commercial ID is invalid'
             ]);
            }

            foreach ($serviceArray['services'] as $service):

                if ($service['service_id'] != '' && $service['service_value'] != '') { //check negative values too

                    $sid = $service['service_id'];

                    // $service_type = Service::where('sid',intval($sid))->first()->toArray()['type'];

                    $data = ServiceLog::create([
                        'service_id' => $service['service_id'],//
                        'value' => $service['service_value'],
                        'when' => Carbon::now(),
                        'device_id' => $device_id
                    ]);
                } else {
                    return response()->json(['status' => 0, 'msg' => 'Service or Service Value Not Found']);
                }
            endforeach;

            $device->last_seen = Carbon::now();
            $device->save();
            return response()->json(['status' => 1]);
        } else {
            return response()->json(['status' => 0, 'msg' => 'Service Save Failed,Please Provide Correct Commercial ID']);
        }
    }


    public function CheckDeviceAliveSms($com_id)
    {
        $SMSController = new SMSController();
        $content =100;
        $phone = $this->getPhoneNumber($com_id);
        $sendSMS = $SMSController->sendSMS($phone, $content);
        return $sendSMS;
    }
    public function getPhoneNumber($com_id)
    {
        $device_imsi= Device::where('com_id', intval($com_id))->first()->toArray();
        $imsi =  $device_imsi['imsi'];
        $phone = Imsi::where('imsi', (String) $imsi)->first()->phone;
        return $phone;
    }

    public function toggleDevice(Request $request) //set/unset is_alive flag  in devices colletion from arduino device
    {
        $com_id  = $request->get('data');
        $device = Device::where('com_id', intval($com_id))->first();
        $device->is_alive = 1;
        $device->is_alive_when = Carbon::now();
        if ($device->save()) {
            echo 'OK';
        } else {
            echo 'NOT-OK';
        }
    }

    public function availableServicesForCustomer(Request $request)
    {

       ///response ::   service_id,Frequency ; service_id1,Frequency1

        $com_id = $request->get('data');

        $device = Device::where('com_id', intval($com_id))->first();
        if ($device) {
            $device_id = $device->id;
            $services_available = Subscription::where('device_id', $device_id)->get();
            $availableServices = [];

            foreach ($services_available as $sa):
            array_push($availableServices, $sa->service->sid.','.Service::$DEFAULT_FREQ);
            endforeach;
            return implode(";", $availableServices);
        } else {
            return response()->json([
              'msg'=>'Device Not found for this commercialId'
            ]);
        }
    }

    public function checkServices(array $services)
    {
        //print_r($services);die;
        $received_services_from_device = [];
        foreach ($services['services'] as $key => $service) {
            array_push($received_services_from_device, $service['service_id']);
        }
        $total_services_sent_by_device = array_unique($received_services_from_device);

        $com_id = intval($services['com_id']);
        $device = Device::where('com_id', $com_id)->first();

        $device_id=  $device->id;
        $subscribed_services = [];
        $temp_services = Subscription::where('device_id', $device_id)->get();

        foreach ($temp_services as $subscription):

                array_push($subscribed_services, $subscription['service_id']);

        endforeach;

        if (array_diff($total_services_sent_by_device, $subscribed_services)) {
            return 0;
        } else {
            return 1;
        }
    }


    public function checkReceivedServicesData(Request $request)
    {
        $user = $request->get('user_id');
        $device_id = Device::where('user_id', $user)->first()->id;

        if (!$device_id) {
            echo  "Provide Device id ";
            die;
        }

        $subscribed_services = Subscription::where('device_id', $device_id)->get();
        $serviceArray = [];
        foreach ($subscribed_services as $key => $value) {
            array_push($serviceArray, $value->service_id);
        }

        //now check device is receiving subscribed services  data..
        //we will check from service_logs collention

        $time_now = Carbon::now();

        //as we waiting for the subsctibed services data.
        //we set it 1 minute and from 1 min before we are expecting data from Device installed by int-ops team

        $waiting_time =  ServiceLog::$waiting;
        $time = $time_now->subMinutes($waiting_time);

        //return $time;

        $service_log = ServiceLog::where('device_id', $device_id)
                                  ->where('when', '<', $time)
                                  ->orderBy('when', 'ASC')->get()->map(function ($received_services) {
                                      return $received_services->service_id;
                                  });

        $service_log = array_unique($service_log->toArray());

        if (is_null($service_log)) {
            return response()->json([

              'status'=>0,
              'msg'=>"No service's Data Received in Last ".$waiting_time." Minutes"
            ]);
        } else {

            //now we will check we are receiving  services registered by the user

            $services_not_matched =  array_diff($serviceArray, $service_log);

            if (!is_null($services_not_matched)) {
                $service_name = Service::whereIN('_id', $services_not_matched)->get()->map(function ($service) {
                    return $service->name;
                });
                return response()->json([
             'status'=>1,
             'msg'=>$service_name
           ]);
            }

            return response()->json([
             'status'=>1,
             'msg'=>"Service's Data Received Properly"
           ]);
        }
    }
}
