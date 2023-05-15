<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OrderByIdCriteria.
 *
 * @package namespace App\Criteria;
 */
class OrderByIdCriteria implements CriteriaInterface
{
    private $asc;

    public function __construct($asc = true)
    {
        $this->asc = $asc;
    }

    private function order()
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
        return $model->orderBy('_id', $this->order());
    }
}
