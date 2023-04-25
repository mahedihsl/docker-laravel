<?php

namespace App\Http\Controllers\Api\Device;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Microservice\DeviceMicroservice;

class DeviceController extends Controller
{
    private $deviceService;

    public function __construct()
    {
        $this->deviceService = new DeviceMicroservice();
    }

    public function list(Request $request)
    {
        try {
            return response()->json($this->deviceService->list($request->all()));
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

}
