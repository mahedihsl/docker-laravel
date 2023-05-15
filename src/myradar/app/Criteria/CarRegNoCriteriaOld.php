<?php

namespace App\Criteria;

class CarRegNoCriteriaOld extends BaseCriteria
{
    private $reg_no;

    function __construct($reg_no)
    {
        $this->reg_no = $reg_no;
    }

    public function apply($model)
    {
        return $model->where('reg_no', 'like', '%' . $this->reg_no . '%');
    }
}
