<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\DrivingHour;


class DrivingHourTransformer extends TransformerAbstract
{

    public function transform(DrivingHour $model)
    {
        return [
            'id' => $model->id,
            'value' => sprintf('%0.2f', $model->value/(3600)),
            'date' => $model->when->format('d M')
        ];
    }
}
