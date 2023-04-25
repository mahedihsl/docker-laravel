<?php

namespace App\Http\Controllers\Api\Device;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\DeviceRepository;
use App\Entities\Device;

class LoginController extends Controller
{
    /**
     * @var repositorysitory
     */
    private $repository;

    public function __construct(DeviceRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Find a device by IMEI ID
     * This API is used by Concox device during Login packet
     * 
     * @param Illuminate\Http\Request $request
     */
    public function find(Request $request)
    {
        $imei = $request->get('imei');
        $device = Device::where('imei', $imei)->first();

        if (!$device) {
            return response()->json('Device not found', 404);
        }

        $control_method = is_null($device->engine_control) ? Device::$ENGINE_CONTROL_LOCK : $device->engine_control;

        return response()->json([
            'com_id' => $device->com_id,
            'car_id' => $device->car_id,
            'controlled_state' => boolval($device->lock_status),
            'control_method' => $control_method,
            'engine' => $device->engine_status,
            'synthetic_engine' => $device->engine_status,
        ]);
    }

}
