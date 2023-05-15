<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\PositionRepository;
use App\Entities\Position;
use App\Entities\Device;
use App\Presenters\PositionPresenter;
use App\Transformers\PositionTransformer;
use App\Criteria\DeviceIdCriteria;
use App\Criteria\RecentItemCriteria;
use Carbon\Carbon;

/**
 * Class PositionRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class PositionRepositoryEloquent extends BaseRepository implements PositionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Position::class;
    }

    public function save(Device $device, $lat, $lng, $when = null)
    {
        /*        $result = $this->model->raw(function($collection) use ($device, $lat, $lng, $when) {
            return $collection->insertOne([
                'lat' => $lat,
                'lng' => $lng,
                'when' => $when ?: Carbon::now(),
                'device_id' => $device->id,
            ]);
        });

        return $this->model->raw(function($collection) use ($result) {
            return $collection->findOne([
                '_id' => ['$eq' => $result->getInsertedId()]
            ]);
	});*/
        return $this->create([
            'lat' => $lat,
            'lng' => $lng,
            'when' => $when ?: Carbon::now(),
            'device_id' => $device->id,
        ]);
    }

    public function lastPosition($deviceId)
    {
        $device = Device::with(['car'])->find($deviceId);
        if (!$device->car->status) return null;

        $device->update(['live_track' => Carbon::now()]);
        // if ( ! is_null($device->meta->get('pos'))) {
        //     return $device->meta->get('pos');
        // }

        $position = $this->latest($deviceId);
        if (!is_null($position)) {
            $transformer = new PositionTransformer();
            return $transformer->transform($position);
            // return $position->presenter();
        }



        return null;
    }

    private function latest($deviceId)
    {
        return Position::raw(function ($collection) use ($deviceId) {
            return $collection->findOne([
                'device_id' => ['$eq' => $deviceId]
            ], [
                'sort' => ['when' => -1],
            ]);
        });
        // return $this->setPresenter(PositionPresenter::class)
        //         ->pushCriteria(new DeviceIdCriteria($deviceId))
        //         ->pushCriteria(new RecentItemCriteria())
        //         ->skipPresenter()
        //         ->first();
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
