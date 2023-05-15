<?php

namespace App\Http\Controllers\Api\Position;

use App\Entities\Device;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LatLngController extends Controller
{
    public function receive(Request $request)
    {
        $device = Device::first();
        $pos = $device->positions()->create([
            'lat' => $request->get('lat'),
            'lng' => $request->get('lng'),
            'data' => $request->all(),
        ]);

        return response()->json([
            'status' => 1,
        ]);
    }
}
