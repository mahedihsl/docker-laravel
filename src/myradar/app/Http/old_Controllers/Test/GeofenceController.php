<?php

namespace App\Http\Controllers\Test;
use App\Http\Controllers\Controller;
use App\Service\Microservice\GeofenceMicroservice;
use App\Service\Microservice\ServiceException;
use Illuminate\Http\Request;

class GeofenceController extends Controller
{
    private $geofenceService;

    public function __construct() {
      $this->geofenceService = new GeofenceMicroservice();
    }

    public function testCacheRead(Request $request)
    {
      try {
        $car_id = '5f647a61349f761ca4441146';
        return response()->json($this->geofenceService->testCacheRead($car_id));
      } catch (ServiceException $e) {
        return response()->json(['error' => $e->getMessage()]);
      }
    }

    public function testCacheWrite(Request $request)
    {
      try {
        $car_id = '5f647a61349f761ca4441146';
        return response()->json($this->geofenceService->testCacheWrite($car_id));
      } catch (ServiceException $e) {
        return response()->json(['error' => $e->getMessage()]);
      }
    }
}
