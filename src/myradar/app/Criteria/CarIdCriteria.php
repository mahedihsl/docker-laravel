<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class CarIdCriteria
 * @package namespace App\Criteria;
 */
class CarIdCriteria implements CriteriaInterface
{
    /**
     * @var string|array
     */
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
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
        if (is_array($this->id)) {
            return $model->whereIn('car_id', $this->id);
        }

        return $model->where('car_id', $this->id);
    }
}
