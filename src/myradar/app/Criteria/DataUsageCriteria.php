<?php

namespace App\Criteria;

use App\Entities\Recharge;
use App\Entities\User;
class DataUsageCriteria extends BaseCriteria
{
    private $consumed;

    function __construct($consumed)
    {
        $this->consumed = $consumed;
    }

    public function apply($model)
    {
        return $model->where('consumed', '<=', $this->consumed);

    }
}
