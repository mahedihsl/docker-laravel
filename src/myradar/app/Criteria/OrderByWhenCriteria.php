<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OrderByWhenCriteria.
 *
 * @package namespace App\Criteria;
 */
class OrderByWhenCriteria implements CriteriaInterface
{
    /**
     * @var bool
     */
    private $asc;

    public function __construct($asc = true)
    {
        $this->asc = $asc;
    }

    public function order()
    {
        return $this->asc ? 'asc' : 'desc';
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
        return $model->orderBy('when', $this->order());
    }
}
