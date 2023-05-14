<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ModeCriteria.
 *
 * @package namespace App\Criteria;
 */
class ModeCriteria implements CriteriaInterface
{
    private $mode;

    public function __construct($mode)
    {
        $this->mode = intval($mode);
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
        return $model->where('mode', $this->mode);
    }
}
