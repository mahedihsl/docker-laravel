<?php

namespace App\Http\Controllers\Service;

use App\Entities\Service;
use App\Entities\ServiceLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\Subscription;
use App\Entities\Device;
use App\Entities\User;
use App\Http\Controllers\Service\ServiceApiController;
use App\Entities\Car;
use Auth;
use Carbon\Carbon;
use Khill\Lavacharts\Lavacharts as Lava;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return view('service.index');
    }

    public function services(Request $request, $id)
    {
        $car = Car::where('user_id', '=', $id)->first();

        $services = Service::all()->toArray();
        $temp_arr = [];
        foreach ($services as $key => $value) {
            $temp_arr[$value['_id']] = $value['name'];
        }
        if ($car) {
            $device = Device::where('car_id', $car->_id)->first();
            $servicesAssigned = Subscription::all()->where('device_id', $device->id);
            $serviceIdArray = [];
            foreach ($servicesAssigned as $key => $value) {
                array_push($serviceIdArray, $value['service_id']);
            }

            return view('service.customer_services')->with([
          'data' => json_encode(array_unique($serviceIdArray)) ,
          'all_services'=>$temp_arr
      ]);
        } else {
            return view('service.customer_services')->with([
          'result'=>'No Device Found',
          'all_services'=>$temp_arr

        ]);
        }
    }

    //checking services received or not

    public function serviceStream(Request $request)
    {
        $user_id = $request->get('id');
    }

    public function fetchAll(Request $request)
    {
        return response()->json([
            'data' => Service::orderBy('id', 'asc')->get(),
        ]);
    }

    public function create(Request $request)
    {
        return view('service.create');
    }

    public function save(Request $request)
    {
        $previous_sid = Service::all()->last();
        if (!isset($previous_sid['sid'])) {
            $sid = 1;
        } else {
            $sid = $previous_sid->toArray()['sid'];
            $sid++;
        }
        $service = Service::create([
            'name' => $request->get('name'),
            'type' => intval($request->get('type')),
            'sid' => $sid

        ]);

        return redirect('services');
    }

    public function edit(Request $request, $id)
    {
        $service = Service::find($id);

        if (!is_null($service)) {
            return view('service.edit')->with([
                'service' => $service,
            ]);
        }

        return redirect()->back();
    }

    public function update(Request $request)
    {
        $service = Service::find($request->get('id'));

        if (!is_null($service)) {
            $service->update([
                'name' => $request->get('name'),
                'type' => $request->get('type'),
            ]);
        }

        return redirect('services');
    }

    public function UserServiceLog(Request $request)
    {
        $user_id = Auth::user()->id;
    }

    public function delete(Request $request, $id)
    {
        $service = Service::find($id);

        if (!is_null($service)) {
            $service->delete();
        }

        return redirect('services');
    }
}
