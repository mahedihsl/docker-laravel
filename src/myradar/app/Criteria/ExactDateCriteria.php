<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

use Carbon\Carbon;

/**
 * Class ExactDateCriteria
 * @package namespace App\Criteria;
 */
class ExactDateCriteria implements CriteriaInterface
{
    /**
     * @var Carbon
     */
    private $date;

    public function __construct(Carbon $date)
    {
        $this->date = $date;
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
        return $model->where('when', $this->date);
    }
}
