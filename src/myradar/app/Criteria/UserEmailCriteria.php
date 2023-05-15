<?php

namespace App\Criteria;

class UserEmailCriteria extends BaseCriteria
{
    private $email;

    function __construct($email)
    {
        $this->email = $email;
    }

    public function apply($model)
    {
        return $model->where('email', 'like', '%'.$this->email.'%');
    }
}
