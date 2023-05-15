<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use App\Entities\User;

/**
 * Class CarUserPhoneCriteria
 * @package namespace App\Criteria;
 */
class CarUserPhoneCriteria implements CriteriaInterface
{
    private $phone;

    function __construct($phone)
    {
        $this->phone = $phone;
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
        $user_ids = User::where('phone', 'like', '%' . $this->phone . '%')
                    ->get()
                    ->map(function($user){
                        return $user->id;
                    })
                    ->toArray();

        return $model->whereIn('user_id', $user_ids);
    }
}
