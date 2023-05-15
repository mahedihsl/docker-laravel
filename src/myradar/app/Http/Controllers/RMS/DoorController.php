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

    public function getSiteGroups(Request $request)
    {
      try {
        $response = $this->rmsDoorService->getSiteGroups($request->all());
        return response()->json($response);
      } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
      }
    }

    public function saveSiteGroup(Request $request)
    {
      try {
        $response = $this->rmsDoorService->saveSiteGroup($request->all());
        return response()->json($response);
      } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
      }
    }

    public function deleteSiteGroup(Request $request)
    {
      try {
        $response = $this->rmsDoorService->deleteSiteGroup($request->all());
        return response()->json($response);
      } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
      }
    }

    public function getCardList(Request $request)
    {
      try {
        $response = $this->rmsDoorService->getCardList($request->all());
        return response()->json($response);
      } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
      }
    }

    public function saveAccessCard(Request $request)
    {
      try {
        $response = $this->rmsDoorService->saveAccessCard($request->all());
        return response()->json($response);
      } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
      }
    }

    public function getCardGroups(Request $request)
    {
      try {
        $response = $this->rmsDoorService->getCardGroups($request->all());
        return response()->json($response);
      } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
      }
    }

    public function saveCardGroup(Request $request)
    {
      try {
        $response = $this->rmsDoorService->saveCardGroup($request->all());
        return response()->json($response);
      } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
      }
    }

    public function deleteCardGroup(Request $request)
    {
      try {
        $response = $this->rmsDoorService->deleteCardGroup($request->all());
        return response()->json($response);
      } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
      }
    }
    
    public function attachSiteAndCardGroups(Request $request)
    {
      try {
        $response = $this->rmsDoorService->attachSiteAndCardGroups($request->all());
        return response()->json($response);
      } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
      }
    }
}
