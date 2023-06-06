<?php

namespace App\Http\Controllers\Input;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\Device;
use App\Entities\Car;
use App\Entities\FuelCalibration;
use App\Entities\FuelCalibrationInput;

class FuelCalibrationInputController extends Controller
{
      public function store(Request $request)
      {
          $deviceId = $request->get('id');
          $percentage = $request->get('perc');
          if($percentage<0 || $percentage>100){ return response()->error('Invalid value');}
          $device = Device::find($deviceId);
          if(is_null($device)){ return response()->error('No device Found');}
          $car = $device->car;
          if(is_null($car)){ return response()->error('No car found for this device');}

          $prevInput = FuelCalibrationInput::where('device_id','=',$deviceId)->where('car_id', '=', $car->id)->first();
          $fuelValue = $this->getFuelValue($device);

          if(is_null($prevInput)){
            $input = ['device_id' => $deviceId, 'car_id' => $car->id, 'data'=>[['value' => $fuelValue, 'perc' => $percentage]]];
            FuelCalibrationInput::create($input);
          }
          else{
            $data = $prevInput->data;
            array_push($data, ['value' => $fuelValue, 'perc' => $percentage]);
            FuelCalibrationInput::where('device_id','=',$deviceId)->where('car_id', '=', $car->id)->update(['data' => $data]);
          }

          return response()->json();
      }

      public function getFuelValue(Device $device)
      {
          $val = $device->meta->get('prevFuel');
          if(is_null($val)){
            $val = floor($device->meter->get('fuel')->avg());
          }

          return $val;
      }

      public function userData(Request $request, $id)
      {
          $device = Device::where('car_id','=', $id)->first();

          $input = FuelCalibrationInput::where('device_id', $device->id)
                                            ->where('car_id', $id)
                                            ->orderBy('updated_at', 'desc')
                                            ->get()
                                            ->map(function($model){
                                              return [
                                                'id' => $model->id,
                                                'time' => $model->created_at->toDayDateTimeString(),
                                                'data' => collect($model->data)->sortBy('perc')->values()->toArray(),
                                              ];
                                            });

          return response()->json($input);
      }


}
