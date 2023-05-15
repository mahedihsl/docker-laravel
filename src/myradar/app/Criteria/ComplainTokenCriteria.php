<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ComplainTokenCriteria.
 *
 * @package namespace App\Criteria;
 */
class ComplainTokenCriteria implements CriteriaInterface
{
    private $token;

    public function __construct($token)
    {
        $this->token = intval($token);
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
        return $model->where('token', $this->token );
    }
}
