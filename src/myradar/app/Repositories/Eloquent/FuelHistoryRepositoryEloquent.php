<?php

namespace App\Repositories\Eloquent;

use Illuminate\Support\Collection;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\FuelHistoryRepository;
use App\Entities\FuelHistory;
use App\Entities\Device;
use Carbon\Carbon;

/**
 * Class FuelHistoryRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class FuelHistoryRepositoryEloquent extends BaseRepository implements FuelHistoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FuelHistory::class;
    }

    public function save(Device $device, $value)
    {
        return $this->create([
            'value'  => $value,
            'when' => Carbon::now(),
            'device_id' => $device->id,
        ]);
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
