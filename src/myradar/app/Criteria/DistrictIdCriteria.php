<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class DistrictIdCriteria
 * @package namespace App\Criteria;
 */
class DistrictIdCriteria implements CriteriaInterface
{
    private $district_id;

    public function __construct($district_id)
    {
        $this->district_id = $district_id;
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
        return $model->where('district_id', $this->district_id);
    }
}
