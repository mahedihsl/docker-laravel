<?php

namespace App\Http\Controllers\Api\Car;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\CarRepository;
use App\Presenters\CarDatePresenter;
use App\Service\Microservice\CarMicroservice;

class CarController extends Controller
{
    /**
     * @var CarRepository
     */
    private $repository;
    private $carService;

    public function __construct(CarRepository $repository)
    {
        $this->repository = $repository;
        $this->carService = new CarMicroservice();
    }

    public function list(Request $request)
    {
        try {
            return response()->json($this->carService->list($request->all()));
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function dates(Request $request, $id)
    {
        $this->repository->setPresenter(CarDatePresenter::class);

        $car = $this->repository->skipPresenter()->find($id);
        if ( ! is_null($car)) {
            return response()->json($car->presenter(),200);
        }

        return response()->error('Car Not Found');
    }

    public function update(Request $request)
    {
        $car = $this->repository->find($request->get('car_id'));

        if ( ! is_null($car)) {
            $this->repository->updateDates($car, collect($request->all()));

            return response()->json(200);
        }

        return response()->error('Car Not Found');
    }

    public function assignRoute(Request $request)
    {
        try {
            $result = $this->carService->assignRoute($request->all());
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
