<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ThanaIdCriteria
 * @package namespace App\Criteria;
 */
class ThanaIdCriteria implements CriteriaInterface
{
    private $thana_id;

    public function __construct($thana_id)
    {
        $this->thana_id = $thana_id;
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
        return $model->where('thana_id', $this->thana_id);
    }
}
