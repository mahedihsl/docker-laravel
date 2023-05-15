<?php

namespace App\Http\Controllers\RMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Microservice\RMSBatteryMicroservice;
use Exception;

class BatteryController extends Controller
{
  private $rmsBatteryService;

  public function __construct()
  {
    $this->rmsBatteryService = new RMSBatteryMicroservice();
  }

  public function voltageHistory(Request $request)
  {
    try {
      $response = $this->rmsBatteryService->voltageHistory($request->all());
      return response()->json($response);
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
  }

  public function exportVoltage(Request $request)
  {
    try {
      $response = $this->rmsBatteryService->exportVoltage($request->all());
      return response()->json($response);
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
  }

  public function exportCurrent(Request $request)
  {
    try {
      $response = $this->rmsBatteryService->exportCurrent($request->all());
      return response()->json($response);
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
  }

  public function currentTrend(Request $request)
  {
    try {
      $response = $this->rmsBatteryService->currentTrend($request->all());
      return response()->json($response);
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
  }

  public function voltageProfile(Request $request)
  {
    try {
      $response = $this->rmsBatteryService->voltageProfile($request->all());
      return response()->json($response);
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
  }

  public function healthHistory(Request $request)
  {
    try {
      $response = $this->rmsBatteryService->healthHistory($request->all());
      return response()->json($response);
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
  }

  public function criticalSites(Request $request)
  {
    try {
      $response = $this->rmsBatteryService->criticalSites($request->all());
      return response()->json($response);
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
  }

  public function events(Request $request)
  {
    try {
      $response = $this->rmsBatteryService->getEvents($request->all());
      return response()->json($response);
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
  }

  public function energyConsumption(Request $request)
  {
    try {
      $response = $this->rmsBatteryService->getEnergyConsumption($request->all());
      return response()->json($response);
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
  }

  public function powerTrend(Request $request)
  {
    try {
      $response = $this->rmsBatteryService->getPowerTrend($request->all());
      return response()->json($response);
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
  }

  public function powerHistory(Request $request)
  {
    try {
      $response = $this->rmsBatteryService->getPowerHistory($request->all());
      return response()->json($response);
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
  }
}
