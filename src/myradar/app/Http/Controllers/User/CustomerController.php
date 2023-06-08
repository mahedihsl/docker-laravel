<?php

namespace App\Http\Controllers\User;

use App\Entities\User;
use App\Entities\Car;
use App\Entities\Device;
use App\Http\Requests\CreateCustomer;
use App\Http\Requests\UpdateCustomer;
use App\Http\Requests\UpdatePassword;
use App\Contract\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Criteria\CustomerNameCriteria;
use App\Criteria\NRecordsCriteria;
use App\Events\CustomerCreated;
use App\Presenters\CustomerPresenter;
use App\Presenters\CustomerInfoPresenter;
use App\Presenters\UserInfoPresenter;
use App\Service\Microservice\ServiceException;
use App\Service\Microservice\UserMicroservice;
use App\Transformers\StatusLogTransformer;


class CustomerController extends Controller
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
        return view('customer.index');
    }

    public function manage(Request $request, $id)
    {
        $user = $this->repository->find($id);

        if ( ! is_null($user)) {
            return view('customer.manage')->with([
                'user' => $user,
            ]);
        }

        return abort(404);
    }

    public function modules(Request $request)
    {
        return view('customer.modules');
    }

    public function save(CreateCustomer $request)
    {
        $data = collect($request->all());
        $user = $this->repository->saveCustomer($data);

        if ( ! is_null($user)) {
            event(new CustomerCreated($user, $data));
            try {
                $service = new UserMicroservice();
                $service->onAccountCreated(['user_id' => $user->id]);
            } catch (ServiceException $e) {}
            return response()->ok([
                'redirect' => route('manage.customer', ['id' => $user->id])
            ]);
        }

        return response()->error();
    }

    public function update(UpdateCustomer $request)
    {
        $data = collect($request->all());

        if (! $request->user()->isAdmin()) {
            $data->forget('phone');
        }

        $this->repository->setPresenter(CustomerPresenter::class);
        $user = $this->repository
                    ->skipPresenter()
                        ->updateCustomer($request->get('id'), $data);

        if ( ! is_null($user)) {
            return response()->ok($user->presenter());
        }

        return response()->error('Error, Try Again !');
    }

    public function password(UpdatePassword $request)
    {
        $model = $this->repository->update([
            'password' => bcrypt($request->get('password')),
        ], $request->get('id'));

        if ( ! is_null($model)) {
            return response()->ok();
        }

        return response()->error();
    }

    public function findByPhone(Request $request, $phone)
    {
        $user = User::where('phone', '=', $phone)->first();

        if ( ! is_null($user)) {
            $cars = $user->cars->map(function($car) {
                return [
                    'id' => $car->id,
                    'label' => $car->reg_no,
                ];
            });

            return response()->json([
                'status' => 1,
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'image' => $user->image_url,
                'cars' => $cars,
                'ref_no'=> $user->ref_no,
            ]);
        }

        return response()->json([
            'status' => 0,
        ]);
    }

    public function getIds(Request $request)
    {
      $this->repository->setPresenter(UserInfoPresenter::class);
      //$this->repository->pushCriteria(new NRecordsCriteria(5));
      return response()->ok($this->repository->get());
    }

    public function toggleHistory(Request $request, $id)
    {
        try {
            $service = new UserMicroservice();
            return response()->ok($service->statusHistory($id));
        } catch (ServiceException $e) {
            return response()->error($e->getMessage());
        }
        // $user = $this->repository->find($id);

        // if ( ! is_null($user)) {
        //     $list = $user->status_log()
        //         ->orderBy('_id', 'desc')->get()
        //         ->map(function($item) {
        //             $transformer = new StatusLogTransformer();
        //             return $transformer->transform($item);
        //         });

        //     return response()->ok($list);
        // }

        // return response()->error();
    }
}
