<?php

namespace App\Http\Controllers\Car;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\CarRepository;
use App\Service\Microservice\SpeedMicroservice;
use App\Service\Microservice\ServiceException;

class SpeedController extends Controller
{
    /**
     * @var CarRepository
     */
    private $repository;

    private $speedService;

    public function __construct(CarRepository $repository)
    {
        $this->repository = $repository;
        $this->speedService = new SpeedMicroservice();
    }

    public function show(Request $request, $id)
    {
        try {
            return response()->ok($this->speedService->find($id));
        } catch (ServiceException $e) {
            return response()->error($e->getMessage());
        }
    }

    public function update(Request $request)
    {
        $car_id = $request->get('id');

        $soft_value = intval($request->get('soft_limit'));
        $soft_active = boolval($request->get('soft_flag'));
        
        $hard_value = intval($request->get('hard_limit'));
        $hard_active = boolval($request->get('hard_flag'));

        try {
            $this->speedService->update($car_id, $soft_value, $soft_active, $hard_value, $hard_active);
            return response()->ok();
        } catch (ServiceException $e) {
            return response()->error($e->getMessage());
        }
    }

}
