<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\User;
use App\Transformers\CarDetailsTransformer;

/**
 * Class AuthUserTransformer.
 *
 * @package namespace App\Transformers;
 */
class AuthUserTransformer extends TransformerAbstract
{
    /**
     * Transform the AuthUser entity.
     *
     * @param \App\Entities\User $model
     *
     * @return array
     */
    public function transform(User $model)
    {
        return [
            'meta' => [
                'max_fence' => config('car.fence.limit'),
                'fence_count' => 0,
            ],
            'user' => [
                'id' => $model->id,
                'nid' => $model->nid,
                'name' => $model->name,
                'email' => $model->email,
                'phone' => $model->phone,
                'api_token' => $model->api_token,
            ],
            'cars' => $model->devices
                        ->filter(function($device) {
                            return !is_null($device->car_id);
                        })
                        ->map(function($device) {
                            if ( ! $device->car->status) {
                                return null;
                            }
                            $transformer = new CarDetailsTransformer();
                            return $transformer->transform($device->car);
                        })
                        ->filter(function($val) {
                            return ! is_null($val);
                        })
                        ->values()
                        ->toArray()
        ];
    }
}
