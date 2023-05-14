<?php

namespace App\Http\Controllers\Service;

use App\Entities\Car;
use App\Entities\Device;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Log\ServiceLog;
use App\Service\Microservice\HealthMicroservice;
use App\Service\Microservice\ServiceException;

class ServiceLogController extends Controller
{
    private $service;

    public function __construct() {
        $this->service = new HealthMicroservice();
    }

    public function history(Request $request, $car, $service)
    {
        $service = new ServiceLog($car, $service);
        return response()->ok($service->get());
    }

    public function report(Request $request, $car_id)
    {
        $device = Device::where('car_id', $car_id)->first();
        if (is_null($device)) {
            return response()->error('Device not found');
        }

        try {
            $response = $this->service->report($device->id);
            return response()->ok($response);
        } catch (ServiceException $e) {
            return response()->error($e->getMessage());
        }
    }
}
