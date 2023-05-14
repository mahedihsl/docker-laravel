<?php

namespace App\Http\Controllers\Api\Car;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Microservice\TripMicroservice;

class TripController extends Controller
{
    private $tripService;

    public function __construct()
    {
        $this->tripService = new TripMicroservice();
    }

    public function history(Request $request)
    {
        try {
            return response()->json($this->tripService->history($request->all()));
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
    
    public function test(Request $request)
    {
        try {
            return response()->json($this->tripService->test($request->all()));
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
