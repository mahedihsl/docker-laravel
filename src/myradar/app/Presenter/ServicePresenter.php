<?php

namespace App\Presenter;

use App\Presenter\BasePresenter;

class ServicePresenter extends BasePresenter
{
    public function __construct()
    {
        parent::__construct();
    }

    public function transform($model)
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'type' => $model->type_text,
            'sid' =>$model->sid
        ];
    }
}
