<?php

namespace App\Http\Controllers\Report;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\Position;

class TrackingController extends Controller
{
    public function report(Request $request)
    {
        $live = intval($request->get('type')) == 1;
        $data = [];
        if ($live) {
            $data['live'] = TRUE;
        } else {
            $data['live'] = FALSE;
            $from_t = $request->get('from_hr') . ':' . $request->get('from_mn') . ' ' . $request->get('from_am');
            $to_t = $request->get('to_hr') . ':' . $request->get('to_mn') . ' ' . $request->get('to_am');

            $from_t = $request->get('date') . ' ' . $from_t;
            $to_t = $request->get('date') . ' ' . $to_t;


          //  $from = Carbon::createFromFormat('m/d/Y h:i a', $from_t);
          //  $to = Carbon::createFromFormat('m/d/Y h:i a', $to_t);


          //  $data['from'] = $from->timestamp;
            //$data['to'] = $to->timestamp;
//
         return $data;

        }


         return $request->all();
    }
}
