<?php

namespace App\Http\Controllers\Car;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TrackingController extends Controller
{
    public function show(Request $request)
    {
        return view('car.tracker')->with([
            'user' => $request->user(),
        ]);
    }
}
