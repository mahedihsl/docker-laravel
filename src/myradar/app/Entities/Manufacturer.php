<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use App\Presenter\ManufacturerPresenter;
use App\Contract\Presenter\ModelPresenter;

class Manufacturer extends Eloquent implements ModelPresenter
{
    protected $guarded = [];

    public function transform($type = null)
    {
        $presenter = new ManufacturerPresenter();
        return $presenter->transform($this);
    }

    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
