<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    public function show(Request $request)
    {
        $user = $this->getWebUser();

        if ( ! is_null($user)) {
            $car = $user->cars()->first();
            if(is_null($car)){
              $car = $user->getSharedCars()->first();
            }
            if ( ! is_null($car)) {
                return view('service.show')->with([
                    'user_id' => $user->id,
                    'car_id' => $car->id,
                    'device_id' => $car->device ? $car->device->id : null,
                ]);
            }
        }

        return $this->redirectToHome('You have no car', 2);
    }
}
