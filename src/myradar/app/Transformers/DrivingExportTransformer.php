<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\DrivingHour;
use Illuminate\Support\Collection;
/**
 * Class ActivationExportTransformer.
 *
 * @package namespace App\Transformers;
 */
class DrivingExportTransformer extends TransformerAbstract
{
    /**
     * Transform the Activation entity.
     *
     * @param
     *
     * @return array
     */
    public function transform(Collection $model)
    {
        return [
            'reg_no' => $model->get('reg_no'),

        ];
    }
}
