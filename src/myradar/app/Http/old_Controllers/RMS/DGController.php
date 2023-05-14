<?php

namespace App\Http\Controllers\RMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Microservice\RMSDGMicroservice;
use Exception;

class DGController extends Controller
{
  private $rmsDgService;

  public function __construct()
  {
    $this->rmsDgService = new RMSDGMicroservice();
  }

  public function runhours(Request $request)
  {
    try {
      $response = $this->rmsDgService->runhours($request->all());
      return response()->json($response);
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
  }
  
  public function exportData(Request $request)
  {
    try {
      $response = $this->rmsDgService->exportData($request->all());
      return response()->json($response);
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
  }

  public function criticalSites(Request $request)
  {
    try {
      $response = $this->rmsDgService->criticalSites($request->all());
      return response()->json($response);
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
  }
  
  public function events(Request $request)
  {
    try {
      $response = $this->rmsDgService->events($request->all());
      return response()->json($response);
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
  }
}
