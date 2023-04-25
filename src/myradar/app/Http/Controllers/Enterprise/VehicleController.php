<?php

namespace App\Http\Controllers\Enterprise;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\CarRepository;
use App\Presenters\EnterpriseCarPresenter;
use App\Criteria\UserIdCriteria;
use App\Criteria\SharedUserCriteria;
use App\Entities\District;

class VehicleController extends Controller
{
    /**
     * @var CarRepository
     */
    public function __construct(CarRepository $repository)
    {
        $this->repository = $repository;
    }


    public function all(Request $request, $userId)
    {
       $this->repository->setPresenter(EnterpriseCarPresenter::class);
       $this->repository->pushCriteria(new UserIdCriteria($userId));
       $this->repository->pushCriteria(new SharedUserCriteria($userId));

       $districtlist = District::orderBy('name', 'asc')->get();

       return response()->ok(['drivers' => $this->repository->all(), 'districtlist' => $districtlist]);
    }
}
