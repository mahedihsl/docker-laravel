<?php

namespace App\Presenter;

class ManufacturerPresenter extends BasePresenter
{

    function __construct()
    {
        parent::__construct();
    }

    public function transform($model)
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
        ];
    }
}
