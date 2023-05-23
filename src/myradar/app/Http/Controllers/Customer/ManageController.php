<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Contract\Repositories\UserRepository;
use App\Presenters\CustomerPresenter;

class ManageController extends Controller
{
    /**
     * @var UserRepository
     */
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function info(Request $request, $id)
    {
        $this->repository->setPresenter(CustomerPresenter::class);
        $customer = $this->repository->find($id);

        if ( ! is_null($customer)) {
            return response()->json($customer);
        }

        return abort(404);
    }
}
