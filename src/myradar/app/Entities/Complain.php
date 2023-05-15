<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;
use Carbon\Carbon;

/**
 * Class Complain.
 *
 * @package namespace App\Entities;
 */
class Complain extends Eloquent implements Presentable
{
    use PresentableTrait;
    protected $guarded = [];
    protected $dates = ['when', 'closed_at'];

    public function getDurationBeforeClosing()
    {
        if (is_null($this->closed_at)) {
            return '--';
        }
        return ($this->when->diffInDays($this->closed_at) + 1) . ' days';
    }

	public function getResponsibleAttribute($value)
	{
		return ! $value ? 0 : intval($value);
	}

    public function getCommentAttribute($value)
    {
        if ( ! $value) return [];

        if (is_string($value)) {
            $obj = [
                'body' => $value,
                'who' => 'unknown',
				'when' => 0,
            ];
            return [$obj];
        }

		for ($i=0, $l=count($value); $i < $l; $i++) {
			if ( ! array_key_exists('when', $value[$i])) {
				$value[$i]['when'] = 0;
			}
		}

        return $value;
    }

    public function car()
    {
      return $this->belongsTo(Car::class);
    }
}
