<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

use Carbon\Carbon;

/**
 * Class TimeOffsetCriteria
 * @package namespace App\Criteria;
 */
class TimeOffsetCriteria implements CriteriaInterface
{
    private $seconds;

    public function __construct($seconds)
    {
        $this->seconds = $seconds;
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
        $now = Carbon::now();
        $before = $now->subSeconds($this->seconds);

        return $model->where('when', '>=', $before)->where('when', '<=', $now);

    }
}
