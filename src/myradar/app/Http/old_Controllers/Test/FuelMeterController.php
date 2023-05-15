<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Refuel\DetectFuelRefuel;
use App\Service\Microservice\FuelMicroservice;

class FuelMeterController extends Controller
{
    public function test(Request $request)
    {
        try {
            $car_id = '5fc8ccfd9617052e31ddefc3';
            $days = 90;
            $fuelService = new FuelMicroservice();
            return response()->json([
                'value' => $fuelService->getRefuelEvents($car_id, $days),
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ]);
        }
    }
}
