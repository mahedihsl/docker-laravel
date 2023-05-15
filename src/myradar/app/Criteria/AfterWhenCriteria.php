<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Carbon\Carbon;

/**
 * Class AfterWhenCriteria.
 *
 * @package namespace App\Criteria;
 */
class AfterWhenCriteria implements CriteriaInterface
{
    /**
     * @var Carbon
     */
    private $when;

    public function __construct(Carbon $time)
    {
        $this->when = $time;
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
        return $model->where('when', '>', $this->when);
    }
}
