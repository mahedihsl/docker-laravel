<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Position;

/**
 * Class PositionTransformer.
 *
 * @package namespace App\Transformers;
 */
class PositionTransformer extends TransformerAbstract
{
    /**
     * Transform the Position entity.
     *
     * @param \App\Entities\Position $model
     *
     * @return array
     */
    public function transform(Position $model)
    {
        return [
            'id' => $model->id,
            'lat' => doubleval($model->lat),
            'lng' => doubleval($model->lng),
            'time' => $model->when->timestamp,
            'when' => $model->when->toDayDateTimeString(),
        ];
    }
}
