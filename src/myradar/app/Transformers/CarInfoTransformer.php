<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Car;
use App\Entities\Device;

/**
 * Class CarInfoTransformer
 * @package namespace App\Transformers;
 */
class CarInfoTransformer extends TransformerAbstract
{

    /**
     * Transform the CarStatus entity
     * @param App\Entities\Car $model
     *
     * @return array
     */
    public function transform(Car $model)
    {
        return [
            'id' => $model->id,
            'reg_no' => $model->reg_no,
            'status' => $model->status,
            // 'device' => $this->getDeviceInfo($model),
        ];
    }

    private function getDeviceInfo(Car $model)
    {
        $device = Device::where('car_id', $model->id)->first();

        if ( ! is_null($device)) {
            return [
                'id' => $device->id,
                'phone' => $device->phone,
            ];
        }

        return null;
    }
}
