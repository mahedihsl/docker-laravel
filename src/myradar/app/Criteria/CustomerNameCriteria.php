<?php

namespace App\Criteria;
use App\Entities\User;

class CustomerNameCriteria extends BaseCriteria
{
    private $name;

    function __construct($name)
    {
        $this->name = $name;
    }

    public function apply($model)
    {
        return $model->where('name', 'like', '%'.$this->name.'%')
                      ->where('type','=',User::$TYPE_CUSTOMER);
    }
}
