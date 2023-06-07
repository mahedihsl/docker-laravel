<?php

namespace App\Http\Controllers\Calibration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Presenters\RefuelFeedPPresenter;
use App\Contract\Repositories\RefuelFeedRepository;
use App\Criteria\CarIdCriteria;
use App\Criteria\WithTypeCriteria;
use App\Criteria\LastUpdatedCriteria;
use App\Presenters\RefuelFeedPresenter;

class RefuelFeedController extends Controller
{
    /**
     * @var RefuelFeedRepository;
     */
    private $repository;

    public function __construct(RefuelFeedRepository $repository)
    {
        $this->repository = $repository;
    }

    public function customer(Request $request)
    {
        return view('customer.refuel')->with([
            'user' => $this->getWebUser()
        ]);
    }

    public function all(Request $request, $id, $type = null)
    {
        $this->repository->setPresenter(RefuelFeedPresenter::class);
        $this->repository->pushCriteria(new CarIdCriteria($id));
        $this->repository->pushCriteria(new LastUpdatedCriteria());

        if ( ! is_null($type)) {
            $this->repository->pushCriteria(new WithTypeCriteria($type));
        }

        return response()->json($this->repository->all());
    }

    public function store(Request $request)
    {
        $item = $this->repository->save(collect($request->all()));

        if ( ! is_null($item)) {
            return response()->json();
        }

        return response()->error('Feed not saved');
    }
}
