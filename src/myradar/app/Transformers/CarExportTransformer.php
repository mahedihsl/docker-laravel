<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Car;

/**
 * Class CarExportTransformer
 * @package namespace App\Transformers;
 */
class CarExportTransformer extends TransformerAbstract
{

    /**
     * Transform the \CarExport entity
     * @param \Car $model
     *
     * @return array
     */
    public function transform(Car $model)
    {
        return [
            'Customer' => $model->user->name,
            'Phone' => $model->user->phone,
            'Remaining' => $model->device->balance ? $model->device->balance->remained.' MB' : '--',
            'Validity' => $model->device->last_recharge ? $model->device->last_recharge->validity->toDateString() : '--',
        ];
    }
}
