<?php

namespace App\Http\Controllers\Calibration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\GasCalibrationRepository;
use App\Criteria\CarIdCriteria;
use App\Criteria\LastUpdatedCriteria;
use App\Presenters\GasCalibrationPresenter;
use App\Events\GasCalibrationCreated;
use App\Entities\Car;
use App\Entities\Device;
use App\Entities\GasRefuelInput;
use App\Entities\Event;
use Carbon\Carbon;

class GasCalibrationController extends Controller
{
    /**
     * @var GasCalibrationRepository
     */
    private $repository;

    public function __construct(GasCalibrationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request, $id)
    {
        $car = Car::find($id);
        $list = $this->repository
                    ->setPresenter(GasCalibrationPresenter::class)
                    ->pushCriteria(new CarIdCriteria($id))
                    ->pushCriteria(new LastUpdatedCriteria())
                    ->all();

        return response()->json([
            'list' => $list,
            'type' => $car->meta_data['cng_type'],
        ]);
    }

    public function store(Request $request)
    {
        $carId = $request->get('car_id');
        $data = json_decode($request->get('data'), true);
        $item = $this->repository->save($carId, $data);

        if ( ! is_null($item)) {
            return response()->json();
        }

        return response()->error('Gas calibration not saved');
    }

    public function remove(Request $request)
    {
        $flag = $this->repository->delete($request->get('id'));
        return $flag ? response()->json() : response()->error();
    }


    public function getGasMin(Request $request , $id)
    {
      $car = Car::find($id);
      if(is_null($car->device)){
        return response()->error('No device found for this car');
      }

      return response()->json($car->device->meta);
    }

    public function setGasMin(Request $request , $id, $value)
    {
      $car = Car::find($id);
      if(is_null($car->device)){
        return response()->error('No device found for this car');
      }
      $car->device->update(["meta.gas_min" =>  $value ]);

      return response()->json();
    }

    public function refuelInput(Request $request, $id)
    {
      $deviceId = Device::where('car_id', '=', $id)->first()->id;

      $data = GasRefuelInput::with(['event' => function($query){
                                  $query->select('created_at');
                              }])
                              ->where('device_id', $deviceId)
                              ->where('car_id', $id)
                              ->orderBy('magnitude')
                              ->get()
                              ->map(function($item){
                                $time = $item->event ? $item->event->created_at->format('d-m-y h:i a') : '--';
                                return [
                                      'time' => $time,
                                      'magnitude' => $item->magnitude,
                                      'base' => $item->base,
                                      'price' => $item->price,
                                      'factor'=> $item->factor,
                                    ];
                              });

      return response()->json($data);

    }


}
