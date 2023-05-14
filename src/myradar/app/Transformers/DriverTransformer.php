<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Driver;
use Carbon\Carbon;

/**
 * Class DriverTransformer.
 *
 * @package namespace App\Transformers;
 */
class DriverTransformer extends TransformerAbstract
{
    /**
     * Transform the Driver entity.
     *
     * @param \App\Entities\Driver $model
     *
     * @return array
     */
    public function transform(Driver $model)
    {
        $car = $model->car;
        if ( ! is_null($car)) {
            $car = [
                'id'    => $car->id,
                'name'  => $car->reg_no,
            ];
        }

        return [
            'id'        => $model->id,
            'name'      => $model->name,
            'phone'     => $model->phone,
            'car'       => $car,
            'booked'    => $model->isBookedAt(Carbon::now()),
        ];
    }
}
