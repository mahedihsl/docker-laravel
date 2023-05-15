<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Car;

/**
 * Class CarDriverTransformer.
 *
 * @package namespace App\Transformers;
 */
class CarDriverTransformer extends TransformerAbstract
{
    /**
     * Transform the CarDriver entity.
     *
     * @param \App\Entities\Car $model
     *
     * @return array
     */
    public function transform(Car $model)
    {
        return [
            'id' => $model->id,
            'name' => $model->reg_no,
            'driver' => $this->getDriver($model),
        ];
    }

    public function getDriver($car)
    {
        if (is_null($car->driver)) return null;

        return [
            'id'    => $car->driver->id,
            'name'  => $car->driver->name,
            'phone' => $car->driver->phone,
        ];
    }
}
