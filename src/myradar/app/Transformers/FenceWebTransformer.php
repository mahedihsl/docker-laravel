<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Fence;
use App\Entities\User;

/**
 * Class FenceWebTransformer
 * @package namespace App\Transformers;
 */
class FenceWebTransformer extends TransformerAbstract
{
    /**
     * @var App\Entities\User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    private function isSelected($fence_id) {
        return isset($this->user->fence_ids)
            && is_array($this->user->fence_ids)
            && in_array($fence_id, $this->user->fence_ids);
    }

    /**
     * Transform the \Fence entity
     * @param \Fence $model
     *
     * @return array
     */
    public function transform(Fence $model)
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'selected' => $this->isSelected($model->id),
        ];
    }
}
