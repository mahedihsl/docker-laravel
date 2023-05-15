<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Device;

/**
 * Class DeviceExportTransformer.
 *
 * @package namespace App\Transformers;
 */
class DeviceExportTransformer extends TransformerAbstract
{
    /**
     * Transform the Activation entity.
     *
     * @param \App\Entities\Device $model
     *
     * @return array
     */
    public function transform(Device $model)
    {
        return [
            'Commercial_id' => $model->com_id,
            'Phone'   => $model->phone,
            'IMEI'   => $model->imei,
            'Created_at' => $model->created_at->toDayDateTimeString(),
        ];
    }
}
