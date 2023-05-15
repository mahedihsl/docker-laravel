<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\DailyGas;

/**
 * Class DailyGasTransformer
 * @package namespace App\Transformers;
 */
class DailyGasTransformer extends TransformerAbstract
{

    /**
     * Transform the DailyGas entity
     * @param App\Entities\DailyGas $model
     *
     * @return array
     */
    public function transform(DailyGas $model)
    {
        return [
            'id' => $model->id,
            'value' => $model->value,
            'when' => $model->when->format('j M'),
        ];
    }
}
