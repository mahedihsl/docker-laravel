<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Microservice\JT808Microservice;

class JT808Controller extends Controller
{
    private $microservice;

    public function __construct()
    {
        $this->microservice = new JT808Microservice();
    }

    public function lock(Request $request)
    {
        try {
            $comId = 33573;
            $res = $this->microservice->lock($comId);
            return response()->json($res);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function unlock(Request $request)
    {
        try {
            $comId = 33573;
            $res = $this->microservice->unlock($comId);
            return response()->json($res);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function status(Request $request)
    {
        try {
            $comId = $request->get('com_id');
            $res = $this->microservice->status($comId);
            return response()->json($res);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
