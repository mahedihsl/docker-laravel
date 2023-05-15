<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Operator;

/**
 * Class OperatorTransformer
 * @package namespace App\Transformers;
 */
class OperatorTransformer extends TransformerAbstract
{

    /**
     * Transform the \Operator entity
     * @param \Operator $model
     *
     * @return array
     */
    public function transform(Operator $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
