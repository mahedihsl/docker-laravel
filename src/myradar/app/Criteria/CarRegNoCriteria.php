<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class CarRegNoCriteria
 * @package namespace App\Criteria;
 */
class CarRegNoCriteria implements CriteriaInterface
{
    private $reg_no;

    function __construct($reg_no)
    {
        $this->reg_no = $reg_no;
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
        return $model->where('reg_no', 'like', '%' . $this->reg_no . '%');
    }
}
