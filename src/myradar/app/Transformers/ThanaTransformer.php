<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Thana;

/**
 * Class ThanaTransformer
 * @package namespace App\Transformers;
 */
class ThanaTransformer extends TransformerAbstract
{

    /**
     * Transform the \Thana entity
     * @param \Thana $model
     *
     * @return array
     */
    public function transform(Thana $model)
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
        ];
    }
}
