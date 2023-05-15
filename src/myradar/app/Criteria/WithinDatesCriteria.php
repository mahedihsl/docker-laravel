<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Carbon\Carbon;

/**
 * Class WithinDatesCriteria.
 *
 * @package namespace App\Criteria;
 */
class WithinDatesCriteria implements CriteriaInterface
{
    /**
     * @var Carbon
     */
    private $from;

    /**
     * @var Carbon
     */
    private $to;

    private $field;

    public function __construct(Carbon $from, Carbon $to, $field = null)
    {
        $this->from = $from;
        $this->to = $to->addDay();

        $this->from->setTime(0, 0, 0);
        $this->to->setTime(0, 0, 0);

        $this->field = $field;
    }

    private function getField()
    {
      return ! strlen($this->field) ? 'created_at' : $this->field;
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
        return $model->where($this->getField(), '>=', $this->from)
                    ->where($this->getField(), '<', $this->to);
    }
}
