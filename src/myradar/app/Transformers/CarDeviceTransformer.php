<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Car;

/**
 * Class CarDeviceTransformer.
 *
 * @package namespace App\Transformers;
 */
class CarDeviceTransformer extends TransformerAbstract
{
    /**
     * Transform the CarDevice entity.
     *
     * @param \App\Entities\Car $model
     *
     * @return array
     */
    public function transform(Car $model)
    {
        $device = $model->device;
        $last_pulse = 'Never';
        $com_id = 'N/A';
        $phone = 'N/A';

        if ( ! is_null($device)) {
            $phone = $device->phone;
            $com_id = $device->com_id;
            $last_pulse = $device->last_pulse_label;
        }

        return [
            'id' => $model->id,
            'reg_no' => $model->reg_no,
            'com_id' => $com_id,
            'phone' => $phone,
            'last_pulse' => $last_pulse,
            'target' => route('manage.customer', [
                'id' => $model->user_id,
                'tab' => 'vehicles',
                'target' => $model->id,
            ]),
        ];
    }
}
