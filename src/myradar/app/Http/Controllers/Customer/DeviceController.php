<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\CarRepository;
use App\Contract\Repositories\DeviceRepository;
use App\Criteria\UserIdCriteria;
use App\Entities\User;

class DeviceController extends Controller
{

    /**
     * @var DeviceRepository
     */
    private $repository;

    public function __construct(DeviceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function devices(Request $request, $userId)
    {
        $this->repository->pushCriteria(new UserIdCriteria($userId));
        return $this->repository->all()->map(function($dev) {
            return $dev->id;
        });
    }

    public function cars(Request $request, $userId)
    {
        // TODO: beautify this method
        $user = User::find($userId);

        if ( ! is_null($user)) {
            $cars = resolve(CarRepository::class)
                        ->pushCriteria(new UserIdCriteria($userId))
                        ->scopeQuery(function($query) use ($user) {
                            return $query->orWhere(function($q) use ($user) {
                                $q->whereIn('_id', $user->shared_cars);
                            });
                        })
                        ->with(['device'])
                        ->all()
                        ->filter(function($c) {
                            return ! is_null($c->device);
                        })
                        ->values()
                        ->map(function($car) {
                            return [
                                'id' => $car->id,
                                'name' => $car->reg_no,
                                'device' => $car->device->id,
                                'vehicle_type' => $car->type,
                            ];
                        });

            return response()->ok($cars);
        }

        return response()->error('User not found');
    }
}
