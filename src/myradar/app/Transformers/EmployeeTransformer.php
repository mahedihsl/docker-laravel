<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Employee;

/**
 * Class EmployeeTransformer.
 *
 * @package namespace App\Transformers;
 */
class EmployeeTransformer extends TransformerAbstract
{
    /**
     * Transform the Employee entity.
     *
     * @param \App\Entities\Employee $model
     *
     * @return array
     */
    public function transform(Employee $model)
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'phone' => $model->phone,
        ];
    }
}
