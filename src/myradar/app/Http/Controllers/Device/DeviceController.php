<?php

namespace App\Http\Controllers\Device;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveDevice;
use App\Contract\Repositories\DeviceRepository;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Entities\Device;
use App\Criteria\UserIdCriteria;
use App\Service\Microservice\DeviceMicroservice;
use Excel;
use App\Transformers\DeviceExportTransformer;

class DeviceController extends Controller
{
    /**
     * @var DeviceRepository
     */
    private $repository;
    private $service;

    public function __construct(DeviceRepository $repository)
    {
        $this->repository = $repository;
        $this->service = new DeviceMicroservice();
    }

    public function index(Request $request)
    {
        return view('device.index');
    }

    public function save(SaveDevice $request)
    {
        $comId = $request->input('com_id');
        $phone = $request->input('phone');
        $version = $request->input('version');
        $imei = $request->input('imei');

        if ( ! Device::where('com_id', $comId)->exists()) {
            if ( ! Device::where('phone', $phone)->exists()) {
                $device = $this->repository->save($comId, $phone, $version, $imei);

                return response()->ok([
                    'com_id' => $device->com_id,
                    'phone' => $device->phone,
                    'version' => $device->version,
                    'imei' => $device->imei,
                    'time' => $device->created_at->toDayDateTimeString(),
                ]);
            }

            return response()->error('Duplicate Phone Number');
        }

        return response()->error('Duplicate Commercial ID');
    }

    public function generateId(Request $request)
    {
        while (true) {
            $comId = rand(10000, 99999);
            if ( ! Device::where('com_id', $comId)->exists()) {
                return response()->ok([
                    'com_id' => $comId,
                ]);
            }
        }
    }

    public function recent(Request $request, $skip)
    {
        $devices = Device::orderBy('created_at', 'desc')
                        ->skip(intval($skip))
                        ->limit(30)
                        ->get()
                        ->map(function($device) {
                            return [
                                'com_id' => $device->com_id,
                                'phone' => $device->phone,
                                'imei' => $device->imei,
                                'version' => isset($device->version) ? $device->version : '--',
                                'time' => $device->created_at->toDayDateTimeString(),
                            ];
                        });
        return response()->ok($devices);
    }

    public function print(Request $request)
    {
        $devices = Device::orderBy('created_at', 'desc')
                        ->limit(9)
                        ->get()
                        ->map(function($device) {
                            return $device->com_id;
                        });
        return view('device.codes')->with([
            'codes' => $devices
        ]);
    }

    public function changePhone(Request $request)
    {
        $user = $this->getWebUser();
        if (!$user->isAdmin()) {
            return response()->error('Only admin can change device phone number');
        }

        $phone = $request->get('phone');
        $device = Device::where('car_id', $request->get('car_id'))->first();

        if ( ! is_null($device)) {
            if ( ! Device::where('phone', $phone)->exists()) {
                $device->update([ 'phone' => $phone ]);
                return response()->ok();
            }

            return response()->error('Phone number already in use');
        }

        return response()->error('Device not found');
    }

    public function allOfUser(Request $request, $id)
    {
        $this->repository->pushCriteria(new UserIdCriteria($id));
        return response()->json($this->repository->all(['com_id']));
    }

    public function export(Request $request)
    {

      $data = Device::orderBy('created_at', 'desc')->get();

        Excel::create('Devices', function ($excel) use ($data) {
            $excel->sheet('data', function ($sheet) use ($data) {
                $data->transform(function ($item) {
                    $transformer = new DeviceExportTransformer();
                    return $transformer->transform($item);
                });

                $sheet->fromArray($data->toArray(), null, 'A1', false, true);
            });
        })->download('xls');

        return redirect()->back();
    }

    public function getPhone(Request $request)
    {
      $id = $request->get('id');
      $device = Device::find($id);
      if(is_null($device))
        return response()->error('No Device Found');
      return response()->ok($device->phone);
    }

    public function updateVersion(Request $request)
    {
      $comId      = $request->get('com_id');
      $version = $request->get('version');

      $device = Device::where('com_id', '=', $comId)->update(['version' => $version]);

      return response()->ok();
    }

    public function bindHistory(Request $request)
    {
        $data = $this->service->bindHistory($request->all());
        $data = new LengthAwarePaginator($data['items'], $data['total'], $data['limit'], $data['page']);
        $data->withPath('/device/bind/history');
        return view('device.bind_history')->with([
            'logs' => $data,
            'query' => collect($request->all()),
        ]);
    }

    public function bindExport(Request $request)
    {
        $data = $this->service->allBindRecords();
        Excel::create('Bind History', function ($excel) use ($data) {
            $excel->sheet('data', function ($sheet) use ($data) {
                $collection = collect($data)->map(function($item) {
                    unset($item['id']);
                    return $item;
                });
                $sheet->fromArray($collection->toArray(), null, 'A1', false, true);
            });
        })->download('xls');

        return redirect()->back();
    }
}
