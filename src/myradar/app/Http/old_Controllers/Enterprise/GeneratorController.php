<?php

namespace App\Http\Controllers\Enterprise;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\CarRepository;
use App\Entities\Car;
use Illuminate\Support\Facades\Auth;
use App\Service\Microservice\CarMicroservice;
use App\Service\Microservice\ServiceException;

class GeneratorController extends Controller
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

    public function index(Request $request)
    {
        return view('enterprise.generator');
    }

    public function all(Request $request)
    {
        try {
            $generators = $this->carService->list([
                'user_id' => Auth::user()->id,
                'type' => Car::TYPE_GENERATOR,
            ]);
            return response()->json($generators);
        } catch (ServiceException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
