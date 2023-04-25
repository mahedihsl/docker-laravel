<?php

namespace App\Http\Controllers\Location;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Util\LatLng;
use App\Service\GeoCoding;

class GeoLocationController extends Controller
{
    public function location(Request $request)
    {
        $latlng = new LatLng($request->get('lat'), $request->get('lng'));
        $geo = new GeoCoding($latlng);
        return $geo->getLocation();
    }


    public function setGeofence(Request $request)
    {

      $user_id = $request->get('user_id');
      $lat = $request->get('lat');
      $lng = $request->get('lng');



    }

}
