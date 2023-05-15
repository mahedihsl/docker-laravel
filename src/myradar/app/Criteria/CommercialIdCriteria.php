<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class CommercialIdCriteria
 * @package namespace App\Criteria;
 */
class CommercialIdCriteria implements CriteriaInterface
{
    private $comId;

    /**
     * Whether the condition is being applied on Car collection
     * @var boolean
     */
    private $queryOnCar;

    public function __construct($comId, $queryOnCar = false)
    {
        $this->comId = intval($comId);
        $this->queryOnCar = $queryOnCar;
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
        if ($this->queryOnCar) {
            return $model->whereHas('device', function($q) {
                $q->where('com_id', $this->comId);
            });
        }

        return $model->where('com_id', $this->comId);
    }
}
