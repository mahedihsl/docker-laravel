<?php

namespace App\Http\Controllers\Mileage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Contract\Repositories\MileageRepository;

use App\Criteria\CarIdCriteria;
use App\Criteria\DateRangeCriteria;
use App\Criteria\LastUpdatedCriteria;
use App\Transformers\MileageTransformer;
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
        $items = collect(range(1, $days))->map(function($d) use ($carId) {
            $time = Carbon::today()->subDays($d);
            $record = Mileage::where('car_id', $carId)
                        ->where('when', '=', $time)->first();
            if ( ! is_null($record)) {
                $transformer = new MileageTransformer();
                return $transformer->transform($record);
            }

            return ['value' => 0, 'date' => $time->format('j M')];
        });

        return response()->ok($items);
    }

}
