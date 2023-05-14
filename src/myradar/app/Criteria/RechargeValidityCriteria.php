<?php

namespace App\Criteria;
use App\Entities\Recharge;

class RechargeValidityCriteria extends BaseCriteria
{
    private $validity;

    function __construct($validity)
    {
        $this->validity = $validity;

    }

    public function apply($model)
    {
        $ids = Recharge::where('validity', '<=',$this->validity)->get(['id'])->map(function($item) {
          return $item->id;
        })->toArray();
        return $model->whereIn('id', $ids);
    }
}
