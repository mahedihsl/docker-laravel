<?php

namespace App\Http\Controllers\Enterprise;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateDriver;
use App\Http\Requests\UpdateDriver;
use App\Contract\Repositories\DriverRepository;
use App\Criteria\CarIdCriteria;
use App\Criteria\UserIdCriteria;

class DriverController extends Controller
{
    /**
     * @var DriverRepository
     */
    private $repository;

    public function __construct(DriverRepository $repository)
    {
        $this->repository = $repository;
    }

    public function manage(Request $request)
    {
        return view('enterprise.driver')->with([
            'userId' => $request->user()->id,
            'previous' => $request->previous,
      ]);
    }

    public function index(Request $request, $id)
    {
        $criteria = new UserIdCriteria($id);
        $drivers = $this->repository->pushCriteria($criteria)->all();
        return response()->ok($drivers);
    }

    public function save(CreateDriver $request)
    {
        $model = $this->repository->skipPresenter()->save(collect($request->all()));

        if ( ! is_null($model)) {
            return response()->ok($model->presenter());
        }

        return response()->error('Unknown Error, Try Again');
    }

    public function update(UpdateDriver $request)
    {
        $driver = $this->repository->skipPresenter()->change(collect($request->all()));

        return response()->ok([
            'curr' => $driver->presenter(),
            'prev' => $this->attach($driver, $request->get('car_id')),
        ]);
    }

    public function attach($driver, $carId)
    {
        if (strlen($carId) == 1) {
            return null;
        }

        $prev = $this->repository
                    ->resetCriteria()
                    ->pushCriteria(new CarIdCriteria($carId))
                    ->first();

        if ( ! is_null($prev)) {
            $prev->update(['car_id' => null]);
        }
        $driver->update(['car_id' => $carId]);

        return ($prev && $prev->id != $driver->id) ? $prev->id : null;
    }

    public function delete(Request $request)
    {
        $deleted = $this->repository->delete($request->get('id'));

        return $deleted ? response()->ok() : response()->error();
    }

}
