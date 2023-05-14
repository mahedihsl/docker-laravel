<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Performance;

/**
 * Class PerformanceTransformer.
 *
 * @package namespace App\Transformers;
 */
class PerformanceTransformer extends TransformerAbstract
{
    /**
     * Transform the Performance entity.
     *
     * @param \App\Entities\Performance $model
     *
     * @return array
     */
    public function transform(Performance $model)
    {
        return [
            'id'        => $model->id,
            'com_id'    => $model->device->com_id,
            'deviation' => $model->deviation,
            'target'    => route('manage.customer', [
                'id' => $model->device->user_id,
                'tab' => 'vehicles',
                'target' => $model->car_id,
            ]),
        ];
    }
}
