<?php

namespace App\Presenter;

abstract class BasePresenter
{
    public function __construct()
    {

    }
    
    abstract public function transform($model);
}
