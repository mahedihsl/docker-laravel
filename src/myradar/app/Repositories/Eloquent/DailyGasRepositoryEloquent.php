<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\DailyGasRepository;
use App\Entities\DailyGas;
use App\Presenters\DailyGasPresenter;

/**
 * Class DailyGasRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class DailyGasRepositoryEloquent extends BaseRepository implements DailyGasRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return DailyGas::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
