<?php

namespace App\Http\Controllers\Operator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\OperatorRepository;

class OperatorController extends Controller
{
    /**
     * @var OperatorRepository
     */
    private $repository;

    public function __construct(OperatorRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        return view('operator.index')->with([
            'ops' => $this->repository->all(),
        ]);
    }

    public function edit(Request $request, $id)
    {
        $operator = $this->repository->find($id);

        if ( ! is_null($operator)) {
            return view('operator.edit')->with([
                'op' => $operator,
            ]);
        }

        return abort(404);
    }

    public function update(Request $request)
    {
        $this->repository->change(collect($request->all()));

        return redirect()->route('operators');
    }
}
