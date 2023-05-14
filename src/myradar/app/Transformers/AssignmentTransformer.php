<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Assignment;

/**
 * Class AssignmentTransformer.
 *
 * @package namespace App\Transformers;
 */
class AssignmentTransformer extends TransformerAbstract
{
    /**
     * Transform the Assignment entity.
     *
     * @param \App\Entities\Assignment $model
     *
     * @return array
     */
    public function transform(Assignment $model)
    {
        return [
            'id'        => $model->id,
            'start'     => $model->start,
            'dest'      => $model->dest,
            'from'      => $model->from->timestamp,
            'to'        => $model->to->timestamp,
            'message'   => $model->message,
            'type'      => $model->type,
            'status'    => $model->status,
            'employee'  => $this->employee($model),
            'driver'    => $this->driver($model),
            'car'       => $this->car($model),
        ];
    }

    public function employee($model)
    {
        if ($model->type == Assignment::TYPE_EMPLOYEE) {
            return [
                'id'    => $model->employee->id,
                'name'  => $model->employee->name,
                'phone' => $model->employee->phone,
            ];
        }

        return null;
    }

    public function driver($model)
    {
        return [
            'id'    => $model->driver->id,
            'name'  => $model->driver->name,
            'phone' => $model->driver->phone,
        ];
    }

    public function car($model)
    {
        return [
            'id'    => $model->car->id,
            'name'  => $model->car->reg_no,
        ];
    }
}
