<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\FuelCalibration;

/**
 * Class FuelCalibrationTransformer.
 *
 * @package namespace App\Transformers;
 */
class FuelCalibrationTransformer extends TransformerAbstract
{
    /**
     * Transform the FuelCalibration entity.
     *
     * @param \App\Entities\FuelCalibration $model
     *
     * @return array
     */
    public function transform(FuelCalibration $model)
    {
        return [
            'id' => $model->id,
            'time' => $model->created_at->toDayDateTimeString(),
            'data' => $model->data,
        ];
    }
}
