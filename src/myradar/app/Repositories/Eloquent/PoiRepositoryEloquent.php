<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\PoiRepository;
use App\Presenters\PoiPresenter;
use App\Entities\Poi;

/**
 * Class PoiRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class PoiRepositoryEloquent extends BaseRepository implements PoiRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Poi::class;
    }

    public function presenter()
    {
        return PoiPresenter::class;
    }

    public function lastUpdatedTime()
    {
        $latest = Poi::raw(function($collection) {
            return $collection->findOne([], [
                'sort' => ['updated_at' => -1],
                'limit' => 1,
                'projection' => [
                    'updated_at' => true,
                ]
            ]);
        });

        return $latest->updated_at->timestamp;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
