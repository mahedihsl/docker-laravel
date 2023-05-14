<?php

namespace App\Http\Controllers\User;
use Laravel\Passport\HasApiTokens;
use App\Criteria\UserNameCriteria;
use App\Criteria\UserNotTypeCriteria;
use App\Entities\User;
use App\Http\Requests\CreateUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\UserRepository;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $criteria = new UserNotTypeCriteria(User::$TYPE_CUSTOMER);
        $this->repository->pushCriteria($criteria);

        if ($request->has('name') && strlen($request->get('name'))) {
            $criteria = new UserNameCriteria($request->get('name'));
            $this->repository->pushCriteria($criteria);
        }

        return view('user.index')->with([
            'users' => $this->repository->withTrashed()->all(),
            'params' => $request->all(), 
        ]);
    }

    public function show(Request $request, $id)
    {
        $user = $this->repository->withTrashed()->find($id);

        if ( ! is_null($user)) {
            return view('user.show')->with([
                'user' => $user,
            ]);
        }

        return redirect()->back();
    }

    public function create(Request $request)
    {
        return view('user.create');
    }

    public function save(CreateUser $request)
    {
        $this->repository->saveUser(collect($request->all()));

        return redirect('users');
    }

    public function edit(Request $request, $id)
    {
        $user = $this->repository->withTrashed()->find($id);

        if ( ! is_null($user)) {
            return view('user.edit')->with([
                'user' => $user,
            ]);
        }

        return redirect()->back();
    }

    public function update(Request $request)
    {
        $this->repository->update([
            'name' => $request->get('name'),
            'phone' => $request->get('phone'),
            'nid' => $request->get('nid'),
            'type' => $request->get('type'),
            'note' => '',
        ], $request->get('id'));

        return redirect('users');
    }

    public function deactivate(Request $request, $id)
    {
        $user = User::find($id);

        if ( ! is_null($user)) {
            $user->delete();
        }

        return redirect('users');
    }

    public function activate(Request $request, $id)
    {
        $user = User::onlyTrashed()->find($id);

        if ( ! is_null($user)) {
            $user->restore();
        }

        return redirect('users');
    }
}
