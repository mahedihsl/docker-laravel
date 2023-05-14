<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\FenceLogRepository;
use App\Entities\FenceLog;

/**
 * Class FenceLogRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class FenceLogRepositoryEloquent extends BaseRepository implements FenceLogRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FenceLog::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
