<?php

namespace App\Http\Controllers\Car;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;

use App\Entities\Car;
use App\Entities\Position;
use App\Entities\GasHistory;
use App\Entities\FuelHistory;
use App\Contract\Repositories\CarRepository;
use App\Contract\Repositories\DeviceRepository;
use App\Criteria\CarIdCriteria;
use App\Criteria\CommercialIdCriteria;
use App\Repositories\Eloquent\DeviceRepositoryEloquent;
use App\Service\PackageService;
use App\Jobs\OnDeviceBindedJob;
use App\Service\Microservice\DeviceMicroservice;
use App\Service\Microservice\ServiceException;

class DeviceController extends Controller
{
    private $cars;
    private $devices;
    private $service;

    public function __construct(CarRepository $cars, DeviceRepository $devices)
    {
        $this->cars = $cars;
        $this->devices = $devices;
        $this->service = new DeviceMicroservice();
    }

    public function state(Request $request, $id)
    {
        $this->devices->pushCriteria(new CarIdCriteria($id));

        try {
            $shared = in_array($request->get('user_id'), Car::find($id)->shared_with);
            $device = $this->devices->first();
            $flag = ! is_null($device);
            return response()->json([
                'car_id'    => $id,
                'shared'    => $shared,
                'value'     => $flag ? 1 : 0,
                'pulse'     => $flag ? $device->last_pulse_label : 'Never',
                'label'     => $flag ? $device->com_id : 'No Device',
                'phone'     => $flag ? $device->phone : 'N/A',
                'device_id' => $flag ? $device->id : null,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->error('Car Not Found');
        }
    }

    public function bind(Request $request)
    {
        $criteria = new CommercialIdCriteria($request->get('com_id'));
        $this->devices->pushCriteria($criteria);
        $device = $this->devices->first();

        if (is_null($device)) {
            return response()->error('Device Not Found');
        }

        try {
            $car_id = $request->get('car_id');
            $this->service->bindDevice($car_id, $device->com_id);

            dispatch(new OnDeviceBindedJob($device->id, $car_id));

            return response()->json('Commercial ID attached');
        } catch (ServiceException $e) {
            return response()->error($e->getMessage());
        }
    }

    public function status(Request $request, $cid, $sid)
    {
        $device = $this->cars->find($cid)->device;
        $status = false;

        switch ($sid) {
            case PackageService::LATLNG:
                $status = Position::where('device_id', $device->id)->exists();
                break;
            case PackageService::FUEL:
                $status = FuelHistory::where('device_id', $device->id)->exists();
                break;
            case PackageService::GAS:
                $status = GasHistory::where('device_id', $device->id)->exists();
                break;
            case PackageService::ENGINE:
                $status = true;
                break;
            case PackageService::SPEED:
                $status = true;
                break;
            case PackageService::MILEAGE:
                $status = true;
                break;
            case PackageService::GEOFENCE:
                $status = true;
                break;

            default:
                $status = false;
                break;
        }

        return response()->json([
            'status' => $status,
            'id' => $sid,
        ]);
    }

    public function unbind(Request $request)
    {
        try {
            $this->service->unbindDevice($request->get('car_id'));
            return response()->json();
        } catch (ServiceException $e) {
            return response()->error($e->getMessage());
        }
    }

}
