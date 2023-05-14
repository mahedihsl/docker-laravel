<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Message;

/**
 * Class MessageTransformer.
 *
 * @package namespace App\Transformers;
 */
class MessageTransformer extends TransformerAbstract
{
    /**
     * Transform the Message entity.
     *
     * @param \App\Entities\Message $model
     *
     * @return array
     */
    public function transform(Message $model)
    {
        return [
            'id' => $model->id,
            'name' => $model->name ? $model->name : 'N/A',
            'email' => $model->email,
            'body' => nl2br($model->body),
            'time' => $model->created_at->toDayDateTimeString(),
        ];
    }
}
