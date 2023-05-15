<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\PerformanceRepository;
use App\Entities\Performance;
use App\Presenters\PerformancePresenter;

/**
 * Class PerformanceRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class PerformanceRepositoryEloquent extends BaseRepository implements PerformanceRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Performance::class;
    }

    public function presenter()
    {
        return PerformancePresenter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
