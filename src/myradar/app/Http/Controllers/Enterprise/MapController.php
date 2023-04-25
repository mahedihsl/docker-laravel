<?php

namespace App\Http\Controllers\Enterprise;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\Zone;
use App\Service\DirectionService;
use App\Contract\Repositories\CarRepository;
use App\Criteria\UserIdCriteria;
use App\Criteria\SharedUserCriteria;

class MapController extends Controller
{
    private $repository;

    public function __construct(CarRepository $repository)
    {
        $this->repository = $repository;
    }

    public function show(Request $request)
    {
        return view('enterprise.map')->with([
            'user' => $request->user(),
        ]);
    }

    public function cars(Request $request, $id)
    {
        // TODO: optimize method by removing zone find query
        // send zone lat,lng & user id from front-end
        $zone = Zone::find($id);
        $cars = $this->repository
                    ->pushCriteria(new UserIdCriteria($zone->user_id))
                    ->pushCriteria(new SharedUserCriteria($zone->user_id))
                    ->with(['device'])
                    ->all()
                    ->filter(function($car, $key) use ($zone) {
                        return $this->isInsideZone($car, $zone);
                    })
                    ->map(function($car) {
                        return [
                            'id' => $car->id,
                            'name' => $car->reg_no,
                            'device' => $car->device->id,
                            'type' => $car->type,
                        ];
                    })
                    ->values();

        return response()->ok($cars);
    }


    public function isInsideZone($car, $zone)
    {
        if (is_null($car->device)) return false;

        $position = $car->device->meta->get('pos');
        if (is_null($position)) return false;

        $service = new DirectionService();
        $dist = $service->distance(
            $zone->lat, $zone->lng,
            $position['lat'], $position['lng']);
        return $dist <= $zone->radius;
    }

}
