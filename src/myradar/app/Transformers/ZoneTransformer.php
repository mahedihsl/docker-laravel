<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Zone;

/**
 * Class ZoneTransformer.
 *
 * @package namespace App\Transformers;
 */
class ZoneTransformer extends TransformerAbstract
{
    /**
     * Transform the Zone entity.
     *
     * @param \App\Entities\Zone $model
     *
     * @return array
     */
    public function transform(Zone $model)
    {
        return [
            'id'        => $model->id,
            'name'      => $model->name,
            'lat'       => $model->lat,
            'lng'       => $model->lng,
            'radius'    => $model->radius,
        ];
    }
}
