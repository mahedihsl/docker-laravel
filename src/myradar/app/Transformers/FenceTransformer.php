<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Fence;

/**
 * Class FenceTransformer
 * @package namespace App\Transformers;
 */
class FenceTransformer extends TransformerAbstract
{

    /**
     * Transform the \Fence entity
     * @param \Fence $model
     *
     * @return array
     */
    public function transform(Fence $model)
    {
        return [
            'id'     => $model->id,
            'name'   => $model->name,
            'lat'    => $model->lat,
            'lng'    => $model->lng,
            'thana_id' => $model->thana_id,
            'radius' => $model->radius,
            'thana_id' => $model->thana_id,
        ];
    }
}
