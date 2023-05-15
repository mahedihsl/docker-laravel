<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Event;

/**
 * Class EventTransformer.
 *
 * @package namespace App\Transformers;
 */
class EventTransformer extends TransformerAbstract
{
    /**
     * Transform the Event entity.
     *
     * @param \App\Entities\Event $model
     *
     * @return array
     */
    public function transform(Event $model)
    {
        return [
            'id'    => $model->id,
            'title' => $model->title,
            'body'  => $model->body,
            'type'  => $model->type,
            'meta'  => $model->meta, // only used in WebApp, Mobile App doesn't use this field
            'time'  => $model->created_at->format('j M Y'), //, g:i A
        ];
    }
}
