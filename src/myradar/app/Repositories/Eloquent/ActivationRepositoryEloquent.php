<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\ActivationRepository;
use App\Entities\Activation;
use App\Validators\ActivationValidator;

/**
 * Class ActivationRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class ActivationRepositoryEloquent extends BaseRepository implements ActivationRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Activation::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
