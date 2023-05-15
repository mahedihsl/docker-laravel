<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class CustomerTypeCriteria
 * @package namespace App\Criteria;
 */
class CustomerTypeCriteria implements CriteriaInterface
{
    private $type;

    public function __construct($type)
    {
        $this->type = $type;
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
        return $model->where('');
    }
}
