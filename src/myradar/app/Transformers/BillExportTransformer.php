<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Complain;
use App\Entities\Activation;
/**
 * Class CarExportTransformer
 * @package namespace App\Transformers;
 */
class BillExportTransformer extends TransformerAbstract
{

    /**
     * Transform the \Activation entity
     * @param \Activation $model
     *
     * @return array
     */
    public function transform(Activation $model)
    {
        $total = $model->car->totalBill();
        $paid = $model->car->totalPaid();
        $waive = $model->car->totalWaive();
        $due = max(0, $total - $paid - $waive);
		$complain = $model->car->getLatestComplain();
		$status = is_null($complain) ? 'none' : $complain->status;

        return [
            'Customer' => $model->car->user->name,
            'Car No.' => $model->car->reg_no,
            'Date of Activation' => $model->created_at->toDayDateTimeString(),
            'Total' => $total,
            'Paid' => $paid,
            'Due' => $due,
            'Waive' => $waive,
			'Complain' => $status,
        ];
    }
}
