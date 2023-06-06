<?php

namespace App\Http\Controllers\Enterprise;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEmployee;
use App\Http\Requests\UpdateEmployee;
use App\Contract\Repositories\EmployeeRepository;
use App\Presenters\EmployeePresenter;
use App\Criteria\UserIdCriteria;

class EmployeeController extends Controller
{
    /**
     * @var EmployeeRepository
     */
    private $repository;

    public function __construct(EmployeeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function manage(Request $request)
    {
        return view('enterprise.employee')->with([
            'userId' => $request->user()->id,
        ]);
    }

    public function index(Request $request, $id)
    {
        $criteria = new UserIdCriteria($id);
        $list = $this->repository->pushCriteria($criteria)->all();
        return response()->json($list);
    }

    public function save(CreateEmployee $request)
    {
        $model = $this->repository->skipPresenter()->save(collect($request->all()));

        if ( ! is_null($model)) {
            return response()->json($model->presenter());
        }

        return response()->error('Oops ! Error, Try again');
    }

    public function update(UpdateEmployee $request)
    {
        $model = $this->repository->skipPresenter()->change(collect($request->all()));

        if ( ! is_null($model)) {
            return response()->json($model->presenter());
        }

        return response()->error('Oops ! Error, Try again');
    }

    public function delete(Request $request)
    {
        $deleted = $this->repository->delete($request->get('id'));

        return $deleted ? response()->json() : response()->error();
    }

}
