<?php

namespace App\Criteria;

class UserPhoneCriteria extends BaseCriteria
{
    private $phone;

    function __construct($phone)
    {
        $this->phone = $phone;
    }

    public function apply($model)
    {
        //return $model->where('phone', 'like', '%'.$this->phone.'%');
	return $model->where('phone', 'like', '%' . $this->phone . '%')->limit(10)->get();
    }
}
