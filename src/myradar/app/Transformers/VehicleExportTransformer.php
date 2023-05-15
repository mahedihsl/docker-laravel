<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Car;
use App\Entities\Device;
/**
 * Class DeviceExportTransformer.
 *
 * @package namespace App\Transformers;
 */
class VehicleExportTransformer extends TransformerAbstract
{
    /**
     * Transform the Activation entity.
     *
     * @param \App\Entities\Vehicle $model
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
            'Reg_no' => $model->reg_no,
            'Com_id'   => $com_id,
            'Phone'  => $phone,
            //'Last_pulse' => $model->updated_at->toDayDateTimeString(),
            'Last_pulse' => $last_pulse
        ];
    }

}
