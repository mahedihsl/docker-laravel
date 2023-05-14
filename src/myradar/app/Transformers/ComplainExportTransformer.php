<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Complain;
use Carbon\Carbon;

/**
 * Class ComplainExportTransformer.
 *
 * @package namespace App\Transformers;
 */
class ComplainExportTransformer extends TransformerAbstract
{
    private $statusTransitions;

    public function __construct($transitions) {
        $this->statusTransitions = $transitions;
    }

    /**
     * Transform the Complain entity.
     *
     * @param \App\Entities\Complain $model
     *
     * @return array
     */
    public function transform(Complain $model)
    {
        $teams = ['N/A', 'CCD', 'Eng - Ops'];
        $getComment = function($list, $i) {
            if (gettype($list) == 'string') {
                return $i == 0 ? $list : '--';
            }
            if (gettype($list) == 'array') {
                if ($i >= count($list)) {
                    return '--';
                }
                return $list[$i]['body'];
            }
            return '--';
        };

        $complainer = 'N/A';
        if ($model->car && $model->car->user) {
            $complainer = $model->car->user->name;
        }

        $dataColumns = [
            'Status' => $model->status,
			'Token'  => $model->token,
			'Car'    => $model->reg_no,
			'Complainer' => $complainer,
            'Creator' => $model->emp,
            'Responsible' => $teams[$model->responsible],
            'When' => $model->when->diffForHumans(),
            'Closed Within' => $model->getDurationBeforeClosing(),
            'Type' => $model->type,
            'Description' => $model->body,
            'Comment #1' => $getComment($model->comment, 0),
            'Comment #2' => $getComment($model->comment, 1),
            'Comment #3' => $getComment($model->comment, 2),
            'Customer Review' => $model->review ? $model->review : '',
        ];

        $transitionColumns = $this->getTransitionColumns($model);

        return array_merge($dataColumns, $transitionColumns);
    }

    public function getTransitionColumns($complain)
    {
        $columns = $this->statusTransitions->mapWithKeys(function($item) {
            return [$item . ' (Days)' => ''];
        });

        if ($complain->status_log) {
            $logs = $complain->status_log;
            $len = count($logs);
            for ($i=0; $i < $len - 1; $i++) { 
                $prevState = $logs[$i]['status'];
                $nextState = $logs[$i + 1]['status'];

                $prevTime = new Carbon($logs[$i]['time']['date'], $logs[$i]['time']['timezone']);
                $nextTime = new Carbon($logs[$i + 1]['time']['date'], $logs[$i + 1]['time']['timezone']);

                $key = $prevState . '-' . $nextState . ' (Days)';
                $days = ceil(($nextTime->diffInHours($prevTime) + 1) / 24);
                $columns->put($key, $days);
            }
        }

        return $columns->toArray();
    }
}
