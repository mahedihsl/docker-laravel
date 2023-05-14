<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Payment;
/**
 * Class CarExportTransformer
 * @package namespace App\Transformers;
 */
class BillDrilldownExportTransformer extends TransformerAbstract
{

    /**
     * Transform the \Payment entity
     * @param \Payment $model
     *
     * @return array
     */
    public function transform(Payment $model, $type, $date)
    {
        $amount = $type == 1 ? $model->getPaidAmountForMonth($date->month, $date->year) : $model->amount;
        $date = $type == 2 ? $model->paid_on->format('j M Y') : $date->format('M Y');

        return [
            'Customer' => $model->user->name,
            'Car No.' => $model->car->reg_no,
            'Date/Time' => $date,
            'Amount' => $amount,
			'Method' => $model->method,
        ];
    }
}
