<?php

namespace App\Http\Controllers\Api\GeoFence;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Microservice\GeofenceMicroservice;

class GeofenceController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new GeofenceMicroservice();
    }

    public function list(Request $request)
    {
        try {
            return response()->json($this->service->getGeofenceList($request->all()));
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function save(Request $request)
    {
        try {
            return response()->json($this->service->saveGeofence($request->all()));
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
    
    public function update(Request $request)
    {
        try {
            return response()->json($this->service->updateGeofence($request->all()));
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function remove(Request $request)
    {
        try {
            $geofenceId = $request->get('id');
            $result = $this->service->removeGeofence($geofenceId);
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function violations(Request $request)
    {
        try {
            $res = $this->service->getViolationHistory($request->all());
            return response()->json($res);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
