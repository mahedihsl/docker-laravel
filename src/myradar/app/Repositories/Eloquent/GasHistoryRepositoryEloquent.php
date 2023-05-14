<?php

namespace App\Repositories\Eloquent;

use Illuminate\Support\Collection;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\GasHistoryRepository;
use App\Entities\GasHistory;
use App\Entities\Device;
use Carbon\Carbon;

/**
 * Class GasHistoryRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class GasHistoryRepositoryEloquent extends BaseRepository implements GasHistoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return GasHistory::class;
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
