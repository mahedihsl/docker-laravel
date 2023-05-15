<?php

namespace App\Search;

use App\Entities\Recharge;
use Illuminate\Support\Collection;
use App\Criteria\RechargeRemainedCriteria;
use App\Contract\Search\RechargeSearch;

class RechargeModelSearch extends BaseModelSearch implements RechargeSearch
{

    function __construct()
    {
        parent::__construct();
    }

    public function init()
    {
        return Recharge::class;
    }

    public function search($paginate = true, $select = ['*'])
    {
        return $this->get($paginate, $select);
    }

}
