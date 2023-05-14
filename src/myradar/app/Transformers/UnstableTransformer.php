<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Unstable;

/**
 * Class UnstableTransformer.
 *
 * @package namespace App\Transformers;
 */
class UnstableTransformer extends TransformerAbstract
{
    /**
     * Transform the Unstable entity.
     *
     * @param \App\Entities\Unstable $model
     *
     * @return array
     */
    public function transform(Unstable $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
