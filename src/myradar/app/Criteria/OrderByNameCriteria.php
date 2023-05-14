<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OrderByNameCriteria.
 *
 * @package namespace App\Criteria;
 */
class OrderByNameCriteria implements CriteriaInterface
{
    private $order;

    public function __construct($asc = true)
    {
        $this->order = $asc ? 'asc' : 'desc';
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
        return $model->orderBy('name', $this->order);
    }
}
