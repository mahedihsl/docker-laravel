<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class NRecordsCriteria
 * @package namespace App\Criteria;
 */
class NRecordsCriteria implements CriteriaInterface
{
    private $count;
    private $skip;

    public function __construct($count, $skip = 0)
    {
        $this->count = intval($count);
        $this->skip = intval($skip);
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
        return $model->skip($this->skip)->take($this->count);
    }
}
