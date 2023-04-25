<?php

namespace App\Http\Controllers\Enterprise;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateZone;
use App\Contract\Repositories\ZoneRepository;
use App\Criteria\UserIdCriteria;
use App\Criteria\OrderByNameCriteria;

class ZoneController extends Controller
{
    /**
     * @var ZoneRepository
     */
    private $repository;

    public function __construct(ZoneRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request, $id)
    {
        $models = $this->repository->pushCriteria(new UserIdCriteria($id))->all();

        return response()->ok($models);
    }

    public function store(CreateZone $request)
    {
        $model = $this->repository->save(collect($request->all()));

        return is_null($model) ? response()->error() : response()->ok($model);
    }

    public function delete(Request $request)
    {
        $deleted = $this->repository->delete($request->get('id'));

        return $deleted ? response()->ok() : response()->error();
    }

}
