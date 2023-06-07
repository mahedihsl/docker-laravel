<?php

namespace App\Http\Controllers\Fence;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Contract\Repositories\DistrictRepository;
use App\Criteria\SortByNameCriteria;

class DistrictController extends Controller
{
    /**
     * @var DistrictRepository
     */
    private $repository;

    public function __construct(DistrictRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $this->repository->pushCriteria(new SortByNameCriteria());

        return response()->json($this->repository->all());
    }
}
