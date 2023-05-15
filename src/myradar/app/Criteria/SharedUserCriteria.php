<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class SharedUserCriteria.
 *
 * @package namespace App\Criteria;
 */
class SharedUserCriteria implements CriteriaInterface
{
    private $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
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
        return $model->orWhere(function($query) {
            $query->where('shared_with', 'all', [$this->userId]);
        });
    }
}
