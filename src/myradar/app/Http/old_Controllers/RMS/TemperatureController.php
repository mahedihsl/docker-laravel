<?php

namespace App\Http\Controllers\RMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Microservice\RMSTemperatureMicroservice;
use Exception;

class TemperatureController extends Controller
{
    private $rmsTemperatureService;

    public function __construct() {
      $this->rmsTemperatureService = new RMSTemperatureMicroservice();
    }

    public function recent(Request $request)
    {
      try {
        $response = $this->rmsTemperatureService->recent($request->all());
        return response()->json($response);
      } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
      }
    }
    
    public function aggregate(Request $request)
    {
      try {
        $response = $this->rmsTemperatureService->aggregate($request->all());
        return response()->json($response);
      } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
      }
    }
    
    public function events(Request $request)
    {
      try {
        $response = $this->rmsTemperatureService->getEvents($request->all());
        return response()->json($response);
      } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
      }
    }
    
    public function criticalSites(Request $request)
    {
      try {
        $response = $this->rmsTemperatureService->getCriticalSites($request->all());
        return response()->json($response);
      } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
      }
    }
}
