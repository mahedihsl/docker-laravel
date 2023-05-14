<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Car;

/**
 * Class CarDateTransformer.
 *
 * @package namespace App\Transformers;
 */
class CarDateTransformer extends TransformerAbstract
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
        return [
            'id' => $model->id,
            'reg_date' => $this->format($model->reg_date),
            'tax_date' => $this->format($model->tax_date),
            'fit_date' => $this->format($model->fitness_date),
            'ins_date' => $this->format($model->insurance_date),
        ];
    }

    private function format($date)
    {
        return is_null($date) ? "" : $date->format('j M Y');
    }
}
