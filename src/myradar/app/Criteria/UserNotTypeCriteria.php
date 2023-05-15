<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class UserNotTypeCriteria.
 *
 * @package namespace App\Criteria;
 */
class UserNotTypeCriteria implements CriteriaInterface
{
    private $type;

    public function __construct($type)
    {
        $this->type = intval($type);
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
        return $model->where('type','<>',$this->type);
    }
}
