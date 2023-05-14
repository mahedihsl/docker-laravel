<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\DailyFuelRepository;
use App\Entities\DailyFuel;
use App\Presenters\DailyFuelPresenter;

/**
 * Class DailyFuelRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class DailyFuelRepositoryEloquent extends BaseRepository implements DailyFuelRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return DailyFuel::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
