<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Activation;

/**
 * Class ActivationExportTransformer.
 *
 * @package namespace App\Transformers;
 */
class ActivationExportTransformer extends TransformerAbstract
{
    /**
     * Transform the Activation entity.
     *
     * @param \App\Entities\Activation $model
     *
     * @return array
     */
    public function transform(Activation $model)
    {
        return [
            'User'    => $model->car->user->name,
            'Phone'   => $model->car->user->phone,
            'Key'     => $model->key,
            'Com. ID' => $model->car->device ? $model->car->device->com_id : 'N/A',
            'Car No.' => $model->car->reg_no,
            'Car Enabled' => $model->car->status == 1 ? 'Yes' : 'No',
            'Acc Enabled' => $model->car->user->isEnabled() ? 'Yes' : 'No',
            'Date'    => $model->created_at->toDayDateTimeString(),
            'Status'  => $model->car->user->status ? 'Current' : 'Old',
        ];
    }
}
