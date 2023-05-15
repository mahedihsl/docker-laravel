<?php

namespace App\Http\Controllers\Service;

use App\Entities\Service;
use App\Entities\Car;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\Subscription;
use App\Entities\Device;
use App\Entities\User;
use App\Entities\ServiceLog;
use Auth;
use Carbon\Carbon;

class ServiceApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $services = Service::all()->map(function ($item) {
            return $item->transform();
        });

        return response()->json($services);
    }

  public function update(Request $request)
  {
   $service_id = $request->get('sid');
   $status   = $request->get('status');
   $user_id = $request->get('user_id');

   $car = Car::where('user_id',$user_id)->first();

    if($car)
     {
     $car_id = $car->_id;
     $device = Device::where('car_id',$car_id)->first();
     $device_id =  $device->_id;

     if($status==0)
       {

         $service = Subscription::where('service_id',$service_id)->where('device_id',$device_id)->first();

         if(Subscription::destroy($service->_id))
          {
          return response()->json(['status'=>1,'msg'=>'Service Deactivated']);
          }
        else{
          return response()->json(['status'=>0,'msg'=>'Service Deactivation Failed']);
       }
     }
       elseif ($status==1) {

       $subscription = Subscription::create([
         'device_id' => $device_id,
         'service_id' => $service_id
       ]);

       return response()->json(['status'=>1,'msg'=>'Service Activated']);
     }

     }
     else{
         return response()->json(['status'=>0,'msg'=>'Car & device  Not Found']);
       }

      }

   public function bindWithComId(Request $request)
   {

       $com_id =intval($request->get('com_id'));
       $car_id =$request->get('car_id');
       $user_id =$request->get('user_id');

       if($com_id)
       {
       $device = Device::where('com_id', $com_id)->first();
        if($device)
           {
             $device_id = $device->id;
            //$user_id = $device->user_id;

             $Device = Device::find($device_id);
             $Device->car_id =$car_id;
             $Device->user_id =$user_id;
             $Device->save();
           }
           else{
             return response()->json(['status'=>0,'msg'=>'commercial Id not found']);
           }
       }
       else{

         return response()->json(['status'=>0,'msg'=>'commercial Id not found']);
       }
       $saveArray = ['status'=>1,'msg'=>'Service Assigned'];

       foreach ($request['selected'] as $key => $serviceID) {

         $service = Service::where('sid',$serviceID)->first();

          $subscription = Subscription::create([
            'device_id' => $device_id,
            'service_id' => $service->id
            //'user_id' =>   $user_id;
          ]);
          if(is_null($subscription))
          {
            return response()->json(['status'=>0,'msg'=>'Service assigning failed!']);

          }
       }

       return response()->json($saveArray);
    }

    public function  checkReceivedServicesData(Request $request)

    {
      $user = $request->get('user');
      $device_id = Device::where('user_id',$user)->first()->id;

      if(!$device_id)
      {
        return "Provide Device id ";
      }


       $subscribed_services = Subscription::where('device_id',$device_id)->get();
       $serviceArray = [];
       foreach ($subscribed_services as $key => $value) {
          array_push($serviceArray,$value->service_id);
       }

      //now check device is receiving subscribed services  data..
      //we will check from service_logs collention

         $time_now = Carbon::now();

      //as we waiting for the subsctibed services data.
      //we set it 1 minute and from 1 min before we are expecting data from Device installed by int-ops team

       $waiting_time =  ServiceLog::$waiting;
       $time = $time_now->subMinutes($waiting_time);

       //return $time;

       $service_log = ServiceLog::where('device_id',$device_id)
                               ->where('when', '<',$time_now)
                               ->orderBy('when', 'ASC')->get()->map(function ($received_services) {
                                 return $received_services->service_id;

                             });

      $service_log = array_unique($service_log->toArray());

       if(is_null($service_log))

       {
         return response()->json([

           'status'=>0,
           'message'=>"No service's Data Received in Last ".$waiting_time." Minutes"
         ]);
       }

       else{

         //now we will check we are receiving  services registered by the user

        $services_not_matched =  array_diff($serviceArray,$service_log);

        if(!is_null($services_not_matched))
        {
        $service_name = Service::whereIN('_id',$services_not_matched)->get()->map(function($service){
                   return $service->name;
        });
        return $service_name;//array

        }

        return response()->json([
          'status'=>1,
          'message'=>"Service's Data Received Properly"
        ]);

       }

    }

    public function get_service_diagnosis(Request $request)
    {
      $user_id = $request->get('user_id');


      $Device = Device::where('user_id',$user_id)->first();

      $from = $request->get('from');
      $to = $request->get('to');

      $service_name = [];
      $service_list = Subscription::where('device_id',$Device->id)->get();

      $subscribed_services = Subscription::where('device_id',$Device->id)->get()->map(function($item) use($service_name) {
        return $item->service->id;
      })->toArray();


      foreach($service_list as $service):
        $service_name[$service->service->id] = $service->service->name;
      endforeach;

      $data = [];

      $from_date = Carbon::createFromFormat('Y-m-d', $from);
      $to_date = Carbon::createFromFormat('Y-m-d', $to);


      $service_log = ServiceLog::where('device_id',$Device->id)
             ->whereIn('service_id',$subscribed_services)
             ->where('when','<',$to_date)
             ->where('when','>',$from_date)
             ->orderBy('when','desc')
             //->orderBy('sid','asc')
             ->select(['service_id','when'])->get();

       foreach($service_log as $key=>$value):
         $data[$value->when->toDateString()][] = $service_name[$value->service_id];
       endforeach;

       $result = array_map("array_unique", $data);

       return response()->json([
         'status'=>1,
         'result'=>json_encode($result),
         'service_name'=>$service_name
       ]);

    }

}
