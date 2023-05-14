<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\DutyHourRepository;
use App\Entities\DutyHour;

/**
 * Class DutyHourRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class DutyHourRepositoryEloquent extends BaseRepository implements DutyHourRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return DutyHour::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
