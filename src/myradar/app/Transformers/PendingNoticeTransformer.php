<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\PendingNotice;
use App\Entities\User;

/**
 * Class PendingNoticeTransformer.
 *
 * @package namespace App\Transformers;
 */
class PendingNoticeTransformer extends TransformerAbstract
{
    /**
     * Transform the Activation entity.
     *
     * @param \App\Entities\PendingNotice $model
     *
     * @return array
     */
    public function transform(PendingNotice $model, User $user)
    {
        $base = [
            'Type' => $model->via,
        ];

        $props = [];
        if ($model->via == 'sms') {
            $props = $this->propsOfSms($model, $user);
        } else {
            $props = $this->propsOfPush($model, $user);
        }
        return array_merge($base, $props);
    }

    public function propsOfPush($model, $user)
    {
        return [
            'Customer' => $user->name,
            'Phone' => $user->phone,
            'Message' => $model->payload['body'],
        ];
    }

    public function propsOfSms($model, $user)
    {
        return [
            'Customer' => $user->name,
            'Phone' => $model->to,
            'Message' => $model->payload,
        ];
    }
}
