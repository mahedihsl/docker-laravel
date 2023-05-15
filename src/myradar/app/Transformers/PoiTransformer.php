<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Poi;

/**
 * Class PoiTransformer
 * @package namespace App\Transformers;
 */
class PoiTransformer extends TransformerAbstract
{

    /**
     * Transform the \Poi entity
     * @param \Poi $model
     *
     * @return array
     */
    public function transform(Poi $model)
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'lat' => $model->loc[1],
            'lng' => $model->loc[0],
        ];
    }
}
