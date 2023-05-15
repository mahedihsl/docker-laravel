<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use App\Entities\User;

/**
 * Class CarUserNameCriteria
 * @package namespace App\Criteria;
 */
class CarUserNameCriteria implements CriteriaInterface
{
    private $name;

    function __construct($name)
    {
        $this->name = $name;
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
        $user_ids = User::where('name', 'like', '%' . $this->name . '%')
                    ->get()
                    ->map(function($user) {
                        return $user->id;
                    })
                    ->toArray();

        return $model->whereIn('user_id', $user_ids);
    }
}
