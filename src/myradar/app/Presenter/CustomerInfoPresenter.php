<?php

namespace App\Presenter;

use App\Presenter\BasePresenter;

class CustomerInfoPresenter extends BasePresenter
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
            'image' => $model->image_url,
            'phone' => $model->phone,
            'type' => $model->customer_type,
            'count' => $model->cars()->count(),
            'device'=> $model->devices()->count(),
            'trashed' => ! is_null($model->deleted_at),
        ];
    }
}
