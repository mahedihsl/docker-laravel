<?php

namespace App\Http\Controllers\Api\GeoFence;

use Illuminate\Http\Request;
use App\Contract\Repositories\FenceRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveFence;
use App\Criteria\ThanaIdCriteria;
use App\Criteria\CarIdCriteria;
use App\Events\FenceAttached;
use App\Events\FenceDeleted;
use App\Events\FenceCreated;
use App\Entities\Car;

class FenceController extends Controller
{
    private $repository;

    public function __construct(FenceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request, $thana)
    {
        $this->repository->pushCriteria(new ThanaIdCriteria($thana));

        return response()->json($this->repository->all());
    }

    public function enterpriseIndex(Request $request, $carId)
    {
      $this->repository->pushCriteria(new CarIdCriteria($carId));

      return response()->json($this->repository->all());
    }

    public function toggle(Request $request)
    {
        $this->repository->skipPresenter();

        $car = Car::find($request->get('car_id'));
        $fence = $this->repository->find($request->get('fence_id'));
        $flag = boolval($request->get('flag'));

        if ( ! is_null($fence) && ! is_null($car)) {
            if ($flag == TRUE) {
                $ids = $car->fence_ids ?: array();
                if (sizeof($ids) < config('car.fence.limit')) {
                    $car->fences()->attach($fence->id);

                    event(new FenceAttached($car, $fence));
                } else {
                    return response()->error('Geofence Limit Exceeded');
                }
            } else {
                $car->fences()->detach($fence->id);
            }

            return response()->json();
        }

        return response()->error('GeoFence Not Found');
    }

    public function save(SaveFence $request)
    {
        $this->repository->skipPresenter();

        $car = Car::find($request->get('car_id'));
        $fence = $this->repository->save($car, collect($request->all()));

        if ( ! is_null($fence)) {
            event(new FenceCreated($car, $fence));

            $is_attached = isset($car->fence_ids) && in_array($fence->id, $car->fence_ids ?: []);

            return response()->json([
                'attached' => $is_attached,
                'message' => 'New Geofence Saved',
            ]);
        }

        return response()->error('Geofence Create Failed');
    }

    public function delete(Request $request)
    {
        $this->repository->skipPresenter();

        $car = Car::find($request->get('car_id'));
        $fence = $this->repository->find($request->get('fence_id'));

    if ( ! is_null($fence) && ! is_null($car)) {
            event(new FenceDeleted($car, $fence));

            return response()->json('Geofence History Deleted');
        }

        return response()->error('Item Not Found');
    }

}
