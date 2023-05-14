<?php

namespace App\Criteria;
use App\Entities\Recharge;

class RechargeRemainedCriteria extends BaseCriteria
{
    private $remained;

    function __construct($remained)
    {
        $this->remained = $remained;

    }

    public function apply($model)
    {
        $ids = Recharge::where('remained', '<=',$this->remained)->get(['id'])->map(function($item) {
          return $item->id;
        })->toArray();
        return $model->whereIn('id', $ids);
    }
}
