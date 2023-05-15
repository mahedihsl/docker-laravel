<?php

namespace App\Criteria;

use App\Entities\User;

class CarOwnerPhoneCriteria extends BaseCriteria
{
    private $phone;

    function __construct($phone)
    {
        $this->phone = $phone;
    }

    public function apply($model)
    {
        $user_ids = User::where('phone', 'like', '%'.$this->phone.'%')
            ->get()->map(function($user) { return $user->id; })->toArray();

        return $model->whereIn('user_id', $user_ids);
    }
}
