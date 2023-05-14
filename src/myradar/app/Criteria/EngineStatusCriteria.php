<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class EngineStatusCriteria
 * @package namespace App\Criteria;
 */
class EngineStatusCriteria implements CriteriaInterface
{
    private $status;

    public function __construct($status)
    {
        $this->status = intval($status);
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
        return $model->where('engine_status', $this->status);
    }
}
