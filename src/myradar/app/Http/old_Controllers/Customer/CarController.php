<?php

namespace App\Http\Controllers\Customer;

use App\Entities\User;
use App\Entities\Car;
use App\Entities\Device;
use App\Entities\Manufacturer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCar;
use App\Mapper\DeviceCreateMapper;
use App\Mapper\DeviceUpdateMapper;

use App\Presenters\CarInfoPresenter;

use App\Contract\Repositories\CarRepository;
use App\Criteria\UserIdCriteria;

class CarController extends Controller
{
    /**
     * @var CarRepository
     */
    private $repository;

    public function __construct(CarRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request, $id)
    {
        $user = User::find($id);

        if ( ! is_null($user)) {
            return view('car.index')->with([
                'user' => $user,
                'cars' => $user->cars,
            ]);
        }

        return redirect()->back();
    }

    public function create(Request $request, $id)
    {
        $user = User::find($id);

        if ( ! is_null($user)) {
            return view('car.create')->with([
                'user' => $user,
                'makers' => Manufacturer::all(),
            ]);
        }

        return redirect()->back();
    }

    public function save(CreateCar $request)
    {
        $car = $this->repository->save(collect($request->all()));

        if ( ! is_null($car)) {
            return response()->ok();
        }

        return response()->error();

        // $user = User::find($request->get('id'));
        //
        // if ( ! is_null($user)) {
        //     $mapper = new DeviceCreateMapper(collect($request->all()));
        //     $user->cars()->create($mapper->getData());
        // }
        //
        // return redirect()->back();
    }

    public function show(Request $request, $id)
    {
        $car = Car::find($id);

        if ( ! is_null($car)) {
            return view('car.show')->with([
                'user' => $car->user,
                'car' => $car,
            ]);
        }

        return redirect()->back();
    }

    public function status(Request $request, $id)
    {
        $device = Device::find($id);
        $car = $device->car;

        if ( ! is_null($car)) {
            return view('car.status')->with([
                'car' => $car,
                'services' => $device->subscriptions
                    ->map(function($item) {return $item->service;}),
            ]);
        }

        return redirect()->back();
    }

    public function edit(Request $request, $id)
    {
        $car = Car::find($id);

        if ( ! is_null($car)) {
            return view('car.edit')->with([
                'user' => $car->user,
                'car' => $car,
                'makers' => Manufacturer::all(),
            ]);
        }

        return redirect()->back();
    }

    public function update(Request $request)
    {
        $car = Car::find($request->get('id'));

        if ( ! is_null($car)) {
            $mapper = new DeviceUpdateMapper(collect($request->all()));
            $car->update($mapper->getData());

            return redirect('car/details/'.$car->id);
        }

        return redirect()->back();
    }

    public function delete(Request $request, $id)
    {
        $car = Car::find($id);
        $user = $car->user;

        if ( ! is_null($car)) {
            $car->delete();
        }

        return redirect('customer/cars/' . $user->id);
    }

    public function all(Request $request, $userId)
    {
        $this->repository->setPresenter(CarInfoPresenter::class);
        $this->repository->pushCriteria(new UserIdCriteria($userId));

        return response()->ok($this->repository->all());
    }

}
