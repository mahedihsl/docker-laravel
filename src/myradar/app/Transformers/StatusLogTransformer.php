<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\StatusLog;

/**
 * Class StatusLogTransformer.
 *
 * @package namespace App\Transformers;
 */
class StatusLogTransformer extends TransformerAbstract
{
    /**
     * Transform the StatusLog entity.
     *
     * @param \App\Entities\StatusLog $model
     *
     * @return array
     */
    public function transform(StatusLog $model)
    {
        return [
            'id' => $model->id,
            'status' => $model->status,
            'date' => $model->created_at->format('j M Y'),
        ];
    }
}
