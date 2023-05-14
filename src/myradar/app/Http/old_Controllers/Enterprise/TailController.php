<?php

namespace App\Http\Controllers\Enterprise;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TailController extends Controller
{
    public function show(Request $request)
    {
        return view('enterprise.tail')->with([
            'userId' => $request->user()->id,
        ]);
    }
}
