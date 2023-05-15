<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\GasCalibrationRepository;
use App\Entities\Device;
use App\Entities\GasCalibration;

/**
 * Class GasCalibrationRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class GasCalibrationRepositoryEloquent extends BaseRepository implements GasCalibrationRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return GasCalibration::class;
    }

    private function transform($data)
    {
        return collect($data)->map(function($o) {
            return [
                'level' => $o['level'],
                'value' => $o['value'],
            ];
        })->sortBy(function($o) {
            return $o['level'];
        })
        ->values();
    }

    public function save($carId, $data)
    {
        $device = Device::where('car_id', $carId)->first();

        if ( ! is_null($device)) {
            return $this->create([
                'device_id' => $device->id,
                'car_id' => $device->car_id,
                'data' => $data,
            ]);
        }

        return null;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
