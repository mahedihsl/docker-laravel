<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\User;

/**
 * Class CustomerInfoTransformer.
 *
 * @package namespace App\Transformers;
 */
class CustomerInfoTransformer extends TransformerAbstract
{
    /**
     * Transform the CustomerInfo entity.
     *
     * @param \App\Entities\CustomerInfo $model
     *
     * @return array
     */
    public function transform(User $model)
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'email' => $model->email,
            'phone' => $model->phone,
            'image' => $model->image_url,
            'cars' => $model->cars->map(function($car) {
                return [
                    'id' => $car->id,
                    'label' => $car->reg_no,
                ];
            }),
        ];
    }
}
