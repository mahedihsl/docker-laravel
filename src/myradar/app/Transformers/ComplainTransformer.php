<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Complain;
use Carbon\Carbon;
/**
 * Class ComplainTransformer.
 *
 * @package namespace App\Transformers;
 */
class ComplainTransformer extends TransformerAbstract
{
    /**
     * Transform the Complain entity.
     *
     * @param \App\Entities\Complain $model
     *
     * @return array
     */
    public function transform(Complain $model)
    {
        return [
            'id'         => $model->id,
            'when'       => $model->when->diffForHumans(),
            'title'      => $model->title,
            'body'       => $model->body,
            'emp'        => $model->emp,
            'user'       => $model->car->user->name,
            'ids'        => [
                                'user' => $model->car->user_id,
                                'car' => $model->car->id
                            ],
            'token'      => $model->token,
            'reg_no'     => $model->reg_no,
            'status'     => $model->status,
            'type'       => $model->type,
            'review'     => $model->review ? $model->review : '',
            'comment'    => $this->getComments($model),
            'date'       => $model->when->format('h:i a,  d M y'),
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at,
			'responsible' => $model->responsible,
        ];
    }

	public function getComments(Complain $model)
	{
		$items = array_reverse($model->comment);
		for ($i=0, $l=count($items); $i < $l; $i++) {
			if ($items[$i]['when'] == 0) {
				$items[$i]['when'] = '-- --';
			} else {
				$items[$i]['when'] = Carbon::createFromTimestamp(intval($items[$i]['when']))
								->format('l j M Y, g:i a');
			}
		}
		return $items;
	}
}
