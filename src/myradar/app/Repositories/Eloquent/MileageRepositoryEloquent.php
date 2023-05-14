<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\MileageRepository;
use App\Presenters\MileagePresenter;
use App\Entities\Mileage;
use App\Entities\Device;
use Carbon\Carbon;

/**
 * Class MileageRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class MileageRepositoryEloquent extends BaseRepository implements MileageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Mileage::class;
    }

    public function transformedDate() //conversion for making day 3AM to 3AM
    {
      $date = Carbon::now()->subHours(3);
      $date->hour = 0;
      $date->minute = 0;
      $date->second = 0;

      return $date;
    }

    public function save(Device $device, $value)
    {
        return $this->create([
            'value' => $value,
            'car_id' => $device->car_id,
            'device_id' => $device->id,
            'when' => $this->transformedDate(),
        ]);
    }

    public function presenter()
    {
        return MileagePresenter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
