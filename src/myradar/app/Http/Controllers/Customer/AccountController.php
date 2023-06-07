<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\UserRepository;
use App\Criteria\ModelTypeCriteria;
use App\Entities\User;
use App\Events\AccountStatusChanged;
use App\Service\Microservice\ServiceException;
use App\Service\Microservice\UserMicroservice;

class AccountController extends Controller
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * @var UserMicroservice
     */
    private $microservice;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
        $this->microservice = new UserMicroservice();

        $criteria = new ModelTypeCriteria(User::$TYPE_CUSTOMER);
        $this->repository->pushCriteria($criteria);
    }

    public function info(Request $request, $id)
    {
        $user = $this->repository->find($id);

        if ( ! is_null($user)) {
            return response()->json([
                'status' => 1,
                'enabled' => $user->isEnabled(),
            ]);
        }

        return response()->json([ 'status' => 0 ]);
    }

    public function toggle(Request $request)
    {
        try {
            $user_id = $request->get('id');
            $actor_id = $request->user()->id;
            
            $response = $this->microservice->toggleStatus($user_id, $actor_id);

            return response()->json([ 'enabled' => $response['status'] ]);
        } catch (ServiceException $e) {
            return response()->json($e->getMessage());
        }
    }
}
