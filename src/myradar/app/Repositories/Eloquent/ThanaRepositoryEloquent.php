<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\ThanaRepository;
use App\Entities\Thana;
use App\Presenters\ThanaPresenter;

/**
 * Class ThanaRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class ThanaRepositoryEloquent extends BaseRepository implements ThanaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Thana::class;
    }

    public function presenter()
    {
        return ThanaPresenter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
