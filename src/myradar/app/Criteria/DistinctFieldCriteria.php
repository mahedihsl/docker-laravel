<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class DistinctFieldCriteria
 * @package namespace App\Criteria;
 */
class DistinctFieldCriteria implements CriteriaInterface
{
    private $field;

    public function __construct($field)
    {
        $this->field = $field;
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
        return $model->distinct($this->field);
    }
}
