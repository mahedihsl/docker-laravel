<?php

namespace App\Http\Controllers\Api\Position;

use App\Entities\Device;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Microservice\MileageMicroservice;

class MileageController extends Controller
{
    private $service;

    public function __construct() {
        $this->service = new MileageMicroservice();
    }

    public function list(Request $request)
    {
        try {
            return response()->json($this->service->history($request->all()));
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
