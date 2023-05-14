<?php

namespace App\Criteria;

abstract class BaseCriteria
{
    function __construct()
    {
        # code...
    }

    abstract public function apply($model);
}
