<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\FuelHistory;

/**
 * Class FuelHistoryTransformer
 * @package namespace App\Transformers;
 */
class FuelHistoryTransformer extends TransformerAbstract
{

    /**
     * Transform the FuelHistory entity
     * @param App\Entities\FuelHistory $model
     *
     * @return array
     */
    public function transform(FuelHistory $model)
    {
        return [
            'id' => $model->id,
            'value' => $model->calibrated / 100,
            'when' => $model->when->format('j M'),
        ];
    }
}
