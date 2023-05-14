<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\GasCalibration;

/**
 * Class GasCalibrationTransformer.
 *
 * @package namespace App\Transformers;
 */
class GasCalibrationTransformer extends TransformerAbstract
{
    /**
     * Transform the GasCalibration entity.
     *
     * @param \App\Entities\GasCalibration $model
     *
     * @return array
     */
    public function transform(GasCalibration $model)
    {
        return [
            'id' => $model->id,
            'time' => $model->created_at->toDayDateTimeString(),
            'data' => $model->data,
        ];
    }
}
