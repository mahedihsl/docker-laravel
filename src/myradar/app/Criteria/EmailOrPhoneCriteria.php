<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class EmailOrPhoneCriteria.
 *
 * @package namespace App\Criteria;
 */
class EmailOrPhoneCriteria implements CriteriaInterface
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
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
        return $model->where(function($query) {
            $query->where('email', $this->value)
                    ->orWhere('phone', $this->value);
        });
    }
}
