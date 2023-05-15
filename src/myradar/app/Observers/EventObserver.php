<?php

namespace App\Observers;

use App\Entities\Event;

class EventObserver
{
    public function creating(Event $model)
    {
        if ($model->type == Event::TYPE_ON) {
            $model->cache = [
                'lat' => 0,
                'gas' => 0,
                'fuel' => 0,
                'wf' => [
                    'pos' => null,
                    'mil' => 0,
                ],
                'wof' => [
                    'pos' => null,
                    'mil' => 0,
                ]
                // ,
                // 'nwf' => [
                //   'mil_pos' => null,
                //   'mil' => 0,
                // ]
            ];
        }
    }
}
