<?php

namespace App\Http\Controllers\Api\GeoFence;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\FenceLogRepository;
use App\Criteria\CarIdCriteria;
use App\Criteria\FenceIdCriteria;
use App\Transformers\FenceLogTransformer;
use App\Entities\Car;
use App\Entities\Fence;
use App\Events\FenceAttached;

class FenceLogController extends Controller
{
    /**
     * @var FenceLogRepository
     */
    private $repository;

    public function __construct(FenceLogRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request, $id)
    {
        $car = Car::find($id);

        if ( ! is_null($car)) {
            $criteria = new CarIdCriteria($car->id);
            $this->repository->pushCriteria($criteria);

            $this->repository->skipPresenter();

            $items = $this->repository->all();
            $items->transform(function($log) use ($car) {
                $transformer = new FenceLogTransformer($car);
                return $transformer->transform($log);
            });

            return response()->json($items);
        }

        return response()->error('No Car Found');
    }

    public function save(Request $request)
    {
        $car = Car::find($request->get('car_id'));
        $fence = Fence::find($request->get('fence_id'));

        if ( ! is_null($car) && ! is_null($fence)) {
            event(new FenceAttached($car, $fence));

            return response()->json('Geofence Added');
        }

        return response()->error('Resource Not Found');
    }

}
