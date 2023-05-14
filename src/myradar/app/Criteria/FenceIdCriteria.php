<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FenceIdCriteria
 * @package namespace App\Criteria;
 */
class FenceIdCriteria implements CriteriaInterface
{
    private $fence_id;

    public function __construct($fence_id)
    {
        $this->fence_id = $fence_id;
    }

    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('fence_id', $this->fence_id);
    }
}
