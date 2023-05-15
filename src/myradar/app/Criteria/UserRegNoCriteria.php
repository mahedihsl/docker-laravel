<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use App\Entities\Car;

/**
 * Class UserRegNoCriteria.
 *
 * @package namespace App\Criteria;
 */
class UserRegNoCriteria implements CriteriaInterface
{
    private $reg_no;

    public function __construct($reg_no)
    {
        $this->reg_no = $reg_no;
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
        $user_ids = Car::where('reg_no', 'like', '%'.$this->reg_no.'%')
                    ->get()
                    ->map(function($item) {
                        return $item->user_id;
                    })
                    ->toArray();
        return $model->whereIn('_id', $user_ids);
    }
}
