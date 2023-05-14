<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\RefuelFeedRepository;
use App\Entities\Device;
use App\Entities\RefuelFeed;
use Illuminate\Support\Collection;

/**
 * Class RefuelFeedRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class RefuelFeedRepositoryEloquent extends BaseRepository implements RefuelFeedRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RefuelFeed::class;
    }

    public function save(Collection $data)
    {
        $device = Device::where('car_id', $data->get('car_id'))->first();

        if ( ! is_null($device)) {
            return $this->create([
                'type' => intval($data->get('type')),
                'method' => intval($data->get('method')),
                'amount' => intval($data->get('amount')),
                'car_id' => $device->car_id,
                'device_id' => $device->id,
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
