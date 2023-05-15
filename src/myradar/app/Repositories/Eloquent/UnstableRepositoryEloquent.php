<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\UnstableRepository;
use App\Entities\Unstable;
use App\Validators\UnstableValidator;

/**
 * Class UnstableRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class UnstableRepositoryEloquent extends BaseRepository implements UnstableRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Unstable::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
