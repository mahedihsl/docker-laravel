<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Mileage;

/**
 * Class MileageTransformer
 * @package namespace App\Transformers;
 */
class MileageTransformer extends TransformerAbstract
{

    /**
     * Transform the \Mileage entity
     * @param \Mileage $model
     *
     * @return array
     */
    public function transform(Mileage $model)
    {
        return [
            'id' => $model->id,
            'value' => round($model->value / 1000, 2),
            'date' => $model->when->format('j M')
        ];
    }
}
