<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

use Carbon\Carbon;

/**
 * Class BillingMonthCriteria
 * @package namespace App\Criteria;
 */
class BillingMonthCriteria implements CriteriaInterface
{
    private $month;
    private $year;

    public function __construct(Carbon $date)
    {
        $this->month = $date->month - 1;
        $this->year = $date->year;
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
        return $model->where('months', 'all', [[$this->month, $this->year]]);
    }
}
