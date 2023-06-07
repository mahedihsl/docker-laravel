<?php

namespace App\Http\Controllers\Fence;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Contract\Repositories\ThanaRepository;
use App\Criteria\DistrictIdCriteria;

class ThanaController extends Controller
{
    /**
     * @var ThanaRepository
     */
    private $repository;

    public function __construct(ThanaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request, $district)
    {
        $this->repository->pushCriteria(new DistrictIdCriteria($district));

        return response()->json($this->repository->all());
    }
}
