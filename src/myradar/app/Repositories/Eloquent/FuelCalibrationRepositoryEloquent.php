<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\FuelCalibrationRepository;
use App\Entities\Device;
use App\Entities\FuelCalibration;

/**
 * Class FuelCalibrationRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class FuelCalibrationRepositoryEloquent extends BaseRepository implements FuelCalibrationRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FuelCalibration::class;
    }

    private function transform($data)
    {
        return collect($data)->map(function($o) {
            return [
                'perc' => $o['perc'],
                'value' => $o['value'],
            ];
        })->sortBy(function($o) {
            return $o['perc'];
        })
        ->values();
    }

    public function save($cariId, $data)
    {
        $device = Device::where('car_id', $cariId)->first();

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
