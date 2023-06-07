<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApiLogin;
use App\Contract\Repositories\UserRepository;
use App\Criteria\ModelTypeCriteria;
use App\Criteria\EmailOrPhoneCriteria;
use App\Presenters\AuthUserPresenter;
use App\Entities\User;

class AuthController extends Controller
{
    /**
     * @var UserRepository
     */
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
        $this->middleware('LogMiddleware');
    }

    public function login(ApiLogin $request)
    {
        $this->repository->setPresenter(AuthUserPresenter::class);

        $this->repository->pushCriteria(new ModelTypeCriteria(User::$TYPE_CUSTOMER));
        $this->repository->pushCriteria(new EmailOrPhoneCriteria($request->get('username')));

        $user = $this->repository->skipPresenter()->first();

        if ( ! is_null($user)) {
            if (Hash::check($request->get('password'), $user->password)) {
                return response()->json($user->presenter());
            }

            return response()->error('Password is Incorrect. Try Again');
        }

        return response()->error('Username not found');
    }

    public function logout(Request $request)
    {
        // $user = $this->getApiUser();
        // $token = $request->get('device_token');
        // //$type = intval($request->get('device_type'));

        // if ($token) {
        //     $user->user_logins()
        //         ->where('device_token', $token)
        //         ->delete();
        //         //->where('device_type', $type)
        // }

        return response()->json();
    }

}
