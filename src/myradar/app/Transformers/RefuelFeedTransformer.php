<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\RefuelFeed;

/**
 * Class RefuelFeedTransformer.
 *
 * @package namespace App\Transformers;
 */
class RefuelFeedTransformer extends TransformerAbstract
{
    /**
     * Transform the RefuelFeed entity.
     *
     * @param \App\Entities\RefuelFeed $model
     *
     * @return array
     */
    public function transform(RefuelFeed $model)
    {
        return [
            'id' => $model->id,
            'amount' => $this->amount($model),
            'time' => $model->created_at->toDayDateTimeString(),
        ];
    }

    private function amount(RefuelFeed $model)
    {
        $prefix = $model->method == RefuelFeed::$METHOD_REFUEL ? 'TOPUP: ' : 'RESERVE: ';
        $ret = $prefix . $model->amount;
        if ($model->type == RefuelFeed::$TYPE_FUEL) {
            $ret .= $model->method == RefuelFeed::$METHOD_REFUEL ? ' Liter' : ' %';
            $ret .= ' of Fuel';
        } else {
            $ret .= $model->method == RefuelFeed::$METHOD_REFUEL ? ' Taka' : ' Level';
            $ret .= ' of Gas';
        }
        return $ret;
    }
}
