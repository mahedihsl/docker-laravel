<?php

namespace App\Search;

use App\Entities\Car;
use Illuminate\Support\Collection;
use App\Contract\Search\CarSearch;

class CarModelSearch extends BaseModelSearch implements CarSearch
{

    function __construct()
    {
        parent::__construct();
    }

    protected function init()
    {
        return Car::class;
    }

    public function search($paginate = true, $select = ['*'])
    {
        return $this->get($paginate, $select);
    }
}
