<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\GasHistory;

/**
 * Class GasHistoryTransformer
 * @package namespace App\Transformers;
 */
class GasHistoryTransformer extends TransformerAbstract
{

    /**
     * Transform the GasHistory entity
     * @param App\Entities\GasHistory $model
     *
     * @return array
     */
    public function transform(GasHistory $model)
    {
        return [
            'id' => $model->id,
            'value' => $model->calibrated,
            'when' => $model->when->format('j M'),
        ];
    }
}
