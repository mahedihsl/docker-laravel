<?php

namespace App\Http\Controllers\Customer;

use Auth;
use App\Entities\User;
use App\Entities\Device;
use App\Entities\Car;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\PackageService;

class PositionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Request $request)
    {
        $user = $this->getWebUser();

        if ($user->devices()->whereNotNull('car_id')->exists() || !is_null($user->shared_cars)) {
            $deviceId = $request->get('device_id', '');
            if ( ! $deviceId) {
                $device = $user->devices()->whereNotNull('car_id')->first();
                if (is_null($device)) {

                    $shared_carIds = $user->shared_cars;
                    if(is_null($shared_carIds) || !sizeof($shared_carIds)){
                      return $this->redirectToHome('You have no car', 2);
                    }
                    else{

                      $carId = $shared_carIds[0];
                      $device = Car::find($carId)->device;
                      if(is_null($device)){
                        return $this->redirectToHome('this car has no device', 2);
                      }

                      $deviceId = $device->id;
                    }

                }
                else{
                  $deviceId = $device->id;
                }

            }

            return $this->tracking($user, $deviceId);
        }

        return $this->redirectToHome('You have no car', 2);
    }

    private function tracking($user, $deviceId)
    {
        $car = Device::find($deviceId)->car;
        $subscribed = in_array(PackageService::LATLNG, $car->services);

        if ($subscribed) {
            return view('position.customer')->with([
                'user' => $user,
                'device' => $deviceId,
                'subscribed' => 1,
            ]);
        }

        return view('position.customer')->with([
            'user' => $user,
            'device' => $deviceId,
            'subscribed' => 0,
        ]);
    }

    public function devices(Request $request, $id)
    {
        $user = User::find($id);

        if ( ! is_null($user)) {
            $positions = $user->devices->map(function($item) {
                return $item->positions()->orderBy('created_at', 'desc')->take(1)->first();
            });

            return response()->json([
                'status' => 1,
                'data' => $positions,
            ]);
        }

        return response()->json([ 'status' => 0, ]);
    }
}
