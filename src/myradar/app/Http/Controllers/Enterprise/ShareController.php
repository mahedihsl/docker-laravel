<?php

namespace App\Http\Controllers\Enterprise;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\CarRepository;
use App\Contract\Repositories\UserRepository;
use App\Presenters\UserInfoPresenter;
use App\Criteria\FullNameCriteria;
use App\Criteria\WithinIdsCriteria;
use App\Criteria\ModelTypeCriteria;
use App\Criteria\PhoneNumberCriteria;
use App\Presenters\CustomerPresenter;
use App\Entities\User;

class ShareController extends Controller
{
    /**
     * @var UserRepository
     */
    private $users;

    /**
     * @var CarRepository
     */
    private $cars;

    public function __construct(UserRepository $users, CarRepository $cars)
    {
        $this->users = $users;
        $this->cars = $cars;
    }

    public function search(Request $request)
    {
        $this->users
            ->setPresenter(UserInfoPresenter::class)
                ->pushCriteria(new ModelTypeCriteria(User::$TYPE_CUSTOMER));

        if (strlen($name = $request->input('name'))) {
            $this->users->pushCriteria(new FullNameCriteria($name));
        }

        if (strlen($phone = $request->input('phone'))) {
            $this->users->pushCriteria(new PhoneNumberCriteria($phone));
        }

        return response()->json($this->users->all());
    }

    public function shared(Request $request)
    {
        $car = $this->cars->find($request->get('car_id'));

        if ( ! is_null($car)) {
            $list = $this->users->setPresenter(UserInfoPresenter::class)
                        ->pushCriteria(new WithinIdsCriteria($car->shared_with))->all();
            return response()->json($list);
        }

        return response()->error();
    }

    public function provide(Request $request)
    {
        $car = $this->cars->find($request->get('car_id'));
        $user = $this->users->find($request->get('user_id'));

        if ( ! (is_null($car) || is_null($user))) {
            $arr = collect($user->shared_cars)->push($car->id)->unique()->values()->toArray();
            $user->update([ 'shared_cars' => $arr ]);

            $arr = collect($car->shared_with)->push($user->id)->unique()->values()->toArray();
            $car->update([ 'shared_with' => $arr ]);

            return response()->json();
        }

        return response()->error();
    }

    public function revoke(Request $request)
    {
        $car = $this->cars->find($request->get('car_id'));
        $user = $this->users->find($request->get('user_id'));

        if ( ! (is_null($car) || is_null($user))) {
            $arr = collect($user->shared_cars)->filter(function($item) use ($car) {
                return $item != $car->id;
            })->values()->toArray();
            $user->update([ 'shared_cars' => $arr ]);

            $arr = collect($car->shared_with)->filter(function($item) use ($user) {
                return $item != $user->id;
            })->values()->toArray();
            $car->update([ 'shared_with' => $arr ]);

            return response()->json();
        }

        return response()->error();
    }
}
