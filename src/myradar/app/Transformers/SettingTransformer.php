<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Setting;

/**
 * Class SettingTransformer
 * @package namespace App\Transformers;
 */
class SettingTransformer extends TransformerAbstract
{

    /**
     * Transform the Setting entity
     * @param App\Entities\Setting $model
     *
     * @return array
     */
    public function transform(Setting $model)
    {
        return [
            'noti_engine' => $model->noti_engine,
            'noti_geofence' => $model->noti_geofence,
            'noti_date' => $model->noti_date,
            'noti_speed' => $model->noti_speed,
        ];
    }
}
