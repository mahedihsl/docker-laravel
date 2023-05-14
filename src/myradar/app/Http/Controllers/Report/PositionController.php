<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Entities\Position;
use App\Entities\Device;


class PositionController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function show(Request $request)
    {
        return view('report.positions');
    }

    public function latest(Request $request)
    {
        $positions = Device::orderBy('id', 'desc')
            ->paginate()
                ->getCollection()
                    ->map(function($item) {
                        return $item->positions()
                            ->orderBy('id', 'desc')
                                ->take(1)
                                    ->first();
                    });

        return response()->json([
            'status' => 1,
            'data' => $positions,
        ]);
    }
}
