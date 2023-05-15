<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

use Carbon\Carbon;

/**
 * Class DateRangeCriteria
 * @package namespace App\Criteria;
 */
class DateRangeCriteria implements CriteriaInterface
{
    /**
     * @var Carbon
     */
    private $from;

    /**
     * @var Carbon
     */
    private $to;

    /**
     * @param int|Carbon $from how many days before today or timestamp | exact date
     * @param int|Carbon $to   how many days before today (0 = today) or timestamp | exact date
     */
    public function __construct($from, $to)
    {
        $this->from = $this->sanitize($from);
        $this->to = $this->sanitize($to);
    }

    /**
     * Converts argument value to Caarbon instance
     * @param  Carbon|int $time     day count, timestamp or Carbon instance
     * @return Carbon               Carbon instance
     */
    private function sanitize($time)
    {
        if (is_string($time) || is_int($time)) {
            if (($time = intval($time)) > intval(1e9)) {
                return Carbon::createFromTimestamp($time);
            }

            return Carbon::today()->subDays($time);
        }

        if (get_class($time) === Carbon::class) {
            return $time;
        }
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
        return $model->where('when', '>=', $this->from)
                        ->where('when', '<=', $this->to);
    }
}
