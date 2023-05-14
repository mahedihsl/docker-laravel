<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\User;

/**
 * Class UserInfoTransformer.
 *
 * @package namespace App\Transformers;
 */
class UserInfoTransformer extends TransformerAbstract
{
    /**
     * Transform the UserInfo entity.
     *
     * @param \App\Entities\UserInfo $model
     *
     * @return array
     */
    public function transform(User $model)
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'phone' => $model->phone,
        ];
    }
}
