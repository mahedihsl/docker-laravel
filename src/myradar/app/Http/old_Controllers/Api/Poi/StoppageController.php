<?php

namespace App\Http\Controllers\Api\Poi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Microservice\GeofenceMicroservice;

class StoppageController extends Controller {
  private $service;

  public function __construct() {
    $this->service = new GeofenceMicroservice();
  }

  public function list(Request $request)
  {
    try {
      return response()->json($this->service->getRingfenceList($request->all()));
    } catch (\Exception $e) {
      return response()->json(['message' => $e->getMessage()], 400);
    }
  }
  
  public function save(Request $request)
  {
    try {
      return response()->json($this->service->saveRingfence($request->all()));
    } catch (\Exception $e) {
      return response()->json(['message' => $e->getMessage()], 400);
    }
  }
  
  public function update(Request $request)
  {
    try {
      return response()->json($this->service->updateRingfence($request->all()));
    } catch (\Exception $e) {
      return response()->json(['message' => $e->getMessage()], 400);
    }
  }
  
  public function remove(Request $request)
  {
    try {
      $stoppageId = $request->get('id');
      $result = $this->service->removeRingfence($stoppageId);
      return response()->json($result);
    } catch (\Exception $e) {
      return response()->json(['message' => $e->getMessage()], 400);
    }
  }
}