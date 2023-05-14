<?php

namespace App\Http\Controllers\Calibration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\CarRepository;
use App\Entities\MetaData;
use App\Entities\Event;
use App\Util\GasPriceFactor;

class MetaDataController extends Controller
{
    /**
     * @var CarRepository
     */
    private $repository;

    public function __construct(CarRepository $repository)
    {
        $this->repository = $repository;
    }

    public function show(Request $request, $id)
    {
        $car = $this->repository->find($id);

        if ( ! is_null($car)) {
            return response()->ok([
                'fuel' => $car->meta_data->get('fuel_factor'),
                'gas' => $car->meta_data->get('gas_factor'),
            ]);
        }

        return response()->error('Car Not Found');
    }

    public function showpricetune(Request $request, $id)
    {
        $car = $this->repository->find($id);

        if ( ! is_null($car)) {
            return response()->ok([
                'fuel' => $car->meta_data->get('fuel_tune_factor'),
                'gas' => $car->meta_data->get('gas_tune_factor'),
            ]);
        }

        return response()->error('Car Not Found');
    }
    public function update(Request $request)
    {
        $car = $this->repository->find($request->get('id'));

        if ( ! is_null($car)) {
            $attr = $request->get('type') == 1 ? 'fuel' : 'gas';
            $car->update([
                "meta_data.{$attr}_factor" => [
                    'data' => GasPriceFactor::deserialize($request->get('factors')),
                    'status' => boolval($request->get('status')),
                    'event_status' => boolval($request->get('event_status')),
                ]
            ]);

            return response()->ok([
                'fuel' => $car->meta_data->get('fuel_factor'),
                'gas' => $car->meta_data->get('gas_factor'),
            ]);
        }

        return response()->error('Car Not Found');
    }

    public function updatepricetune(Request $request)
    {
        $car = $this->repository->find($request->get('id'));

        if ( ! is_null($car)) {
            $attr = $request->get('type') == 1 ? 'fuel' : 'gas';
            $car->update([
                "meta_data.{$attr}_tune_factor" => [
                    'data' => GasPriceFactor::deserialize($request->get('factors')),
                    'status' => boolval($request->get('status')),
                ]
            ]);

            return response()->ok([
                'fuel' => $car->meta_data->get('fuel_tune_factor'),
                'gas' => $car->meta_data->get('gas_tune_factor'),
            ]);
        }

        return response()->error('Car Not Found');
    }


}
