<?php

namespace App\Http\Controllers\Service;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Contract\Repositories\MileageRepository;

use App\Criteria\CarIdCriteria;
use App\Criteria\DateRangeCriteria;
use App\Criteria\LastUpdatedCriteria;
use App\Transformers\MileageTransformer;
use App\Entities\Car;
use App\Entities\Device;
use App\Entities\Mileage;

use Carbon\Carbon;


class MileageController extends Controller
{
    /**
     * @param MileageRepository
     */
    private $repository;

    public function __construct(MileageRepository $repository)
    {
        $this->repository = $repository;
    }

    public function records(Request $request, $carId, $days)
    {
        $car = Car::find($carId);
        if (!$car->status) {
            return response()->json();
        }

        $items = collect(range(0, intval($days) - 1))->map(function($d) use ($carId) {
            $time = Carbon::today()->subDays($d);
            $value = Mileage::where('car_id', $carId)
                        ->where('when', '=', $time)
                        ->sum('value');

            // special check for a customer. Reduce mileage by 7%
            $cars = ['5f63fac936374b3de61baa97'];
            if (in_array($carId, $cars)) {
                $value = $value * 0.93;
            }

            return ['value' => round($value / 1000, 2), 'date' => $time->format('j M'), 'year' => $time->format('Y')];
        });

        return response()->json($items);
    }

    public function archive(Request $request, $id)
    {
        $device = Device::with(['car'])->find($id);
        if (!$device->car->status) {
            return response()->json();
        }
        
        $from = Carbon::createFromFormat('Y-n-j', $request->get('from'));
        $to = Carbon::createFromFormat('Y-n-j', $request->get('to'));

        $days = $from->diffInDays($to);
        $from->setTime(0, 0, 0);
        $to->setTime(0, 0, 0);

        $items = collect(range(0, $days))->map(function($d) use ($id, $to) {
            $time = $to->copy()->subDays($d);
            $value = Mileage::where('device_id', $id)
                        ->where('when', '=', $time)
                        ->sum('value');

            return ['value' => round($value / 1000, 2), 'date' => $time->format('j M'), 'year' => $time->format('Y')];
        });

        return response()->json($items);
    }

}
