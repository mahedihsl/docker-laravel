<?php

namespace App\Http\Controllers\Fence;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Contract\Repositories\FenceRepository;
use App\Transformers\FenceWebTransformer;
use App\Criteria\ThanaIdCriteria;
use App\Events\FenceAttached;

class FenceController extends Controller
{
    /**
     * @var FenceRepository
     */
    private $repository;

    public function __construct(FenceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        return view('fence.index');
    }

    public function items(Request $request, $thana)
    {
        $user = $this->getWebUser();

        $this->repository->skipPresenter();
        $this->repository->pushCriteria(new ThanaIdCriteria($thana));

        $items = $this->repository->all();
        $items->transform(function($fence) use ($user) {
            $transformer = new FenceWebTransformer($user);
            return $transformer->transform($fence);
        });

        return response()->ok($items);
    }

    public function toggle(Request $request)
    {
        $user = $this->getWebUser();
        $this->repository->skipPresenter();

        $fence = $this->repository->find($request->get('fence_id'));
        $flag = boolval($request->get('flag'));

        if ( ! is_null($fence)) {
            if ($flag == TRUE) {
                $ids = ! $user->fence_ids ? array() : $user->fence_ids;
                if (sizeof($ids) < config('car.fence.limit')) {
                    $user->fences()->attach($fence->id);

                    event(new FenceAttached($user, $fence));
                } else {
                    return response()->error('Geofence Limit Exceeded');
                }
            } else {
                $user->fences()->detach($fence->id);
            }

            return response()->ok();
        }

        return response()->error('GeoFence Not Found');
    }
}
