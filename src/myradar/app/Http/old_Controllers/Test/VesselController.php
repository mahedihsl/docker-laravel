<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Service\Microservice\GeofenceMicroservice;
use App\Service\Microservice\ServiceException;
use Illuminate\Http\Request;

class VesselController extends Controller
{
    public function __construct() {
      $this->vessels = [
        [
          'id' => 1,
          'name' => 'এম ভি সুরভি - ৯',
          'location' => null,
        ],
        [
          'id' => 2,
          'name' => 'মর্নিং সান - ২',
          'location' => null,
        ],
        [
          'id' => 3,
          'name' => 'জল তরঙ্গ - ১',
          'location' => null,
        ],
      ];
    }

    public function list(Request $request)
    {
      $id = intval($request->get('id', 0));
      $list = collect($this->vessels);
      if ($id) {
        $list = $list->filter(function($val) use ($id) {
          return $val['id'] == $id;
        });
      }
      return response()->json($list);
    }
}
