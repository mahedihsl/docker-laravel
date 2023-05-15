<?php

namespace App\Http\Controllers\RMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Microservice\RMSMainsMicroservice;
use Exception;

class MainsController extends Controller
{
    private $rmsMainsService;

    public function __construct() {
      $this->rmsMainsService = new RMSMainsMicroservice();
    }

    public function recent(Request $request)
    {
      try {
        $response = $this->rmsMainsService->recent($request->all());
        return response()->json($response);
      } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
      }
    }
    
    public function events(Request $request)
    {
      try {
        $response = $this->rmsMainsService->events($request->all());
        return response()->json($response);
      } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
      }
    }

    public function offhours(Request $request)
    {
      try {
        $response = $this->rmsMainsService->offhours($request->all());
        return response()->json($response);
      } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
      }
    }
    
    public function exportData(Request $request)
    {
      try {
        $response = $this->rmsMainsService->exportData($request->all());
        return response()->json($response);
      } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
      }
    }

    public function criticalSites(Request $request)
    {
      try {
        $response = $this->rmsMainsService->criticalSites($request->all());
        return response()->json($response);
      } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
      }
    }

    public function availability(Request $request)
    {
      try {
        $response = $this->rmsMainsService->availability($request->all());
        return response()->json($response);
      } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
      }
    }
}
