<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use App\Entities\User;

/**
 * Class UserRefNoCriteria.
 *
 * @package namespace App\Criteria;
 */
class UserRefNoCriteria implements CriteriaInterface
{
    private $ref_no;

    public function __construct($ref_no)
    {
        $this->ref_no = $ref_no;
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
        return $model->where('ref_no', 'like', '%' . $this->ref_no . '%');;
    }
}
