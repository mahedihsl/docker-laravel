<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Trip;

/**
 * Class TripTransformer.
 *
 * @package namespace App\Transformers;
 */
class TripTransformer extends TransformerAbstract
{
    /**
     * Transform the Trip entity.
     *
     * @param \App\Entities\Trip $model
     *
     * @return array
     */
    public function transform(Trip $model)
    {
        return [
            'id'    => $model->id,
            'start' => [
                'name' => $model->start_at,
                'time' => $model->start->format('g:i a'),
            ],
            'finish' => [
                'name' => $model->finish_at,
                'time' => $model->finish->format('g:i a'),
            ],
            'duration' => $model->duration . ' Min',
        ];
    }
}
