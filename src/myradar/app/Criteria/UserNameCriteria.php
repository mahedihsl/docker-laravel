<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class UserNameCriteria.
 *
 * @package namespace App\Criteria;
 */
class UserNameCriteria implements CriteriaInterface
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        if ( ! $this->name) return $model;
        return $model->where('name', 'like', '%' . $this->name . '%');
    }
}
