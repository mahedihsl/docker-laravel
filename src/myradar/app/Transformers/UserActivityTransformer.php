<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\User;
use App\Entities\Activity;
use Carbon\Carbon;

/**
 * Class UserActivityTransformer.
 *
 * @package namespace App\Transformers;
 */
class UserActivityTransformer extends TransformerAbstract
{
    /**
     * Transform the UserActivity entity.
     *
     * @param \App\Entities\User $model
     *
     * @return array
     */
    public function transform(User $model)
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'phone' => $model->phone,
            'count' => $model->cars()->count(),
            // 'data' => $this->activity($model),
        ];
    }

    public function activity($user)
    {

    }
}
