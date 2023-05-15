<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\TripRepository;
use App\Entities\Trip;

/**
 * Class TripRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class TripRepositoryEloquent extends BaseRepository implements TripRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Trip::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
