<?php

namespace App\Http\Controllers\RMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Microservice\RMSDoorMicroservice;
use App\Service\Microservice\RMSUserMicroservice;
use Exception;

class DoorController extends Controller
{
    private $rmsDoorService;

    public function __construct() {
      $this->rmsDoorService = new RMSDoorMicroservice();
    }

    public function openhours(Request $request)
    {
      try {
        $response = $this->rmsDoorService->openhours($request->all());
        return response()->json($response);
      } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
      }
    }
    
    public function events(Request $request)
    {
      try {
        $response = $this->rmsDoorService->getEvents($request->all());
        return response()->json($response);
      } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
      }
    }

    public function getAccessRecords(Request $request)
    {
      try {
        $response = $this->rmsDoorService->getAccessRecords($request->all());
        return response()->json($response);
      } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
      }
    }
    
    public function saveAccessRecord(Request $request)
    {
      try {
        $response = $this->rmsDoorService->saveAccessRecord($request->all());
        return response()->json($response);
      } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
      }
    }
    
    public function getAccessCards(Request $request)
    {
      try {
        $response = $this->rmsDoorService->getAccessCards($request->all());
        return response()->json($response);
      } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
      }
    }
    
    public function addAccessCard(Request $request)
    {
      try {
        $response = $this->rmsDoorService->addAccessCard($request->all());
        return response()->json($response);
      } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
      }
    }
    
    public function deleteAccessCard(Request $request)
    {
      try {
        $response = $this->rmsDoorService->deleteAccessCard($request->all());
        return response()->json($response);
      } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
      }
    }
   
    public function clearAccessCardList(Request $request)
    {
      try {
        $response = $this->rmsDoorService->clearAccessCardList($request->all());
        return response()->json($response);
      } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
      }
    }
}
