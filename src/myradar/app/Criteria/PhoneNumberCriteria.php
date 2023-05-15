<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class PhoneNumberCriteria
 * @package namespace App\Criteria;
 */
class PhoneNumberCriteria implements CriteriaInterface
{
    private $phone;

    /**
     * Whether the condition is being applied on Car collection
     * @var boolean
     */
    private $queryOnCar;

    function __construct($phone, $queryOnCar = false)
    {
        $this->phone = $phone;
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
        if ( ! $this->phone) return $model;
        if ($this->queryOnCar) {
            return $model->whereHas('device', function($q) {
                $q->where('phone', 'like', '%'.$this->phone.'%');
            });
        }

        return $model->where('phone', 'like', '%'.$this->phone.'%');
    }
}
