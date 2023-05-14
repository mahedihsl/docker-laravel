<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Car;
use App\Entities\Device;

/**
 * Class CarDetailsTransformer.
 *
 * @package namespace App\Transformers;
 */
class CarDetailsTransformer extends TransformerAbstract
{
    /**
     * Transform the Car entity.
     *
     * @param \App\Entities\Car $model
     *
     * @return array
     */
    public function transform(Car $model)
    {
        $device_id = $model->device ? $model->device->id : null;
        $control_method = Device::$ENGINE_CONTROL_LOCK;
        if ( ! is_null($model->device)) {
            $control_method = is_null($model->device->engine_control) ? Device::$ENGINE_CONTROL_LOCK : $model->device->engine_control;
        }

        return [
            'id'        => $model->id,
            'name'      => $model->name,
            'model'     => $model->model,
            'device_id' => $device_id,
            'reg_no'    => $model->reg_no,
            'reg_date'  => $this->date($model->reg_date),
            'tax_date'  => $this->date($model->tax_date),
            'fit_date'  => $this->date($model->fitness_date),
            'ins_date'  => $this->date($model->insurance_date),
            'fence'     => $model->fences()->count(),
            'type'      => $model->type,
            'cng'       => $model->cng_type,
            'services'  => $model->services,
            'package'   => $model->package,
            'new_service' => $model->new_service,
            'voice_service' => intval($model->voice_service),
            'engine_control' => $control_method,
            'bill'      => $model->bill,
            'meta'      => $model->meta_data,
        ];
    }

    private function date($value)
    {
        return is_null($value) ? "" : $value->format('j M Y');
    }
}
