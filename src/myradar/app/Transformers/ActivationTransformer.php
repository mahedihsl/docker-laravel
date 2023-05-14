<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Activation;

/**
 * Class ActivationTransformer.
 *
 * @package namespace App\Transformers;
 */
class ActivationTransformer extends TransformerAbstract
{
    /**
     * Transform the Activation entity.
     *
     * @param \App\Entities\Activation $model
     *
     * @return array
     */
    public function transform(Activation $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
