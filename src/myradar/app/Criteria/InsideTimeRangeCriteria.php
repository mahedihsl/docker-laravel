<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Carbon\Carbon;

/**
 * Class InsideTimeRangeCriteria.
 *
 * @package namespace App\Criteria;
 */
class InsideTimeRangeCriteria implements CriteriaInterface
{
    private $fromCol = 'from';
    private $toCol = 'to';

    /**
     * @var Carbon
     */
    private $time;

    public function __construct(Carbon $time)
    {
        $this->time = $time;
    }

    public function setColumns($from, $to)
    {
        $this->fromCol = $from;
        $this->toCol = $to;
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
        return $model->where($this->fromCol, '<=', $this->time)
                        ->where($this->toCol, '>=', $this->time);
    }
}
