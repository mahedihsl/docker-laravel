<?php

namespace App\Http\Controllers\Fence;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Contract\Repositories\FenceLogRepository;
use App\Criteria\UserIdCriteria;
use App\Transformers\FenceLogTransformer;

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

    public function index(Request $request)
    {
        $user = $this->getWebUser();

        $this->repository->skipPresenter();
        $this->repository->pushCriteria(new UserIdCriteria($user->id));

        $items = $this->repository->all();
        $items->transform(function($log) use ($user) {
            $transformer = new FenceLogTransformer($user);
            return $transformer->transform($log);
        });

        return response()->json($items);
    }
}
