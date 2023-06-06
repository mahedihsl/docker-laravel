<?php

namespace App\Http\Controllers\Enterprise;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\CarRepository;
use App\Presenters\CarDriverPresenter;
use App\Criteria\UserIdCriteria;
use App\Criteria\SharedUserCriteria;

class CarController extends Controller
{
    /**
     * @var CarRepository
     */
    private $repository;

    public function __construct(CarRepository $repository)
    {
        $this->repository = $repository;
    }

    public function all(Request $request, $id)
    {
        $cars = $this->repository
                    ->setPresenter(CarDriverPresenter::class)
                    ->pushCriteria(new UserIdCriteria($id))
                    ->pushCriteria(new SharedUserCriteria($id))
                    ->with(['driver'])
                    ->all();

        return response()->json($cars);
    }
}
