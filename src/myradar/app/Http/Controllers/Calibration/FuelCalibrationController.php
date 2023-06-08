<?php

namespace App\Http\Controllers\Calibration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\FuelCalibrationRepository;
use App\Criteria\CarIdCriteria;
use App\Criteria\LastUpdatedCriteria;
use App\Presenters\FuelCalibrationPresenter;
use App\Events\FuelCalibrationCreated;
use App\Events\FuelCalibrationRemoved;


class FuelCalibrationController extends Controller
{
    /**
     * @var FuelCalibrationRepository
     */
    private $repository;

    public function __construct(FuelCalibrationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request, $id)
    {
        $this->repository->setPresenter(FuelCalibrationPresenter::class);
        $this->repository->pushCriteria(new CarIdCriteria($id));
        $this->repository->pushCriteria(new LastUpdatedCriteria());

        return response()->ok($this->repository->all());
    }



    public function store(Request $request)
    {
        $data = json_decode($request->get('data'), true);
        $data = collect($data)->sortBy('perc')->values()->toArray();
        $item = $this->repository->save($request->get('car_id'), $data);

        if ( ! is_null($item)) {
            return response()->ok();
        }

        return response()->error('Fuel calibration not saved');
    }

    public function remove(Request $request)
    {
        $flag = $this->repository->delete($request->get('id'));
        return $flag ? response()->ok() : response()->error();
    }

}
