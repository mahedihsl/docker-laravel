<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Microservice\ServiceException;
use App\Service\Microservice\SocketMicroservice;

class SocketController extends Controller
{
    public function send(Request $request)
    {
        try {
            $service = new SocketMicroservice();
            return response()->json($service->send($request->all()));
        } catch (ServiceException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

    }
}
