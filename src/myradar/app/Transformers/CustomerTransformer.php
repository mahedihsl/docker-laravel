<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\User;

/**
 * Class CustomerTransformer
 * @package namespace App\Transformers;
 */
class CustomerTransformer extends TransformerAbstract
{

    /**
     * Transform the \Customer entity
     * @param \Customer $model
     *
     * @return array
     */
    public function transform(User $model)
    {
        return [
            'id'        => $model->id,
            'uid'       => $model->uid,
            'name'      => $model->name,
            'image'     => $model->image_url,
            'phone'     => $model->phone,
            'email'     => $model->email,
            'nid'       => $model->nid,
			'address'	=> $model->address,
            'type'      => $model->customer_type,
            'count'     => $model->cars()->count(),
            'device'    => $model->devices()->count(),
            'trashed'   => ! is_null($model->deleted_at),
            'status'    => $model->status,
            'ref_no'    => isset($model->ref_no) ? $model->ref_no: "",
        ];
    }
}
