<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Health;

/**
 * Class HealthTransformer
 * @package namespace App\Transformers;
 */
class HealthTransformer extends TransformerAbstract
{

    /**
     * Transform the \Health entity
     * @param \Health $model
     *
     * @return array
     */
    public function transform(Health $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
