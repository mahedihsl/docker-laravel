<?php

namespace App\Criteria;

use App\Entities\User;

class CarOwnerNameCriteria extends BaseCriteria
{
    private $name;

    function __construct($name)
    {
        $this->name = $name;
    }

    public function apply($model)
    {
        $user_ids = User::where('name', 'like', '%' . $this->name . '%')
            ->get()->map(function($user) { return $user->id; })->toArray();

        return $model->whereIn('user_id', $user_ids);
    }
}
