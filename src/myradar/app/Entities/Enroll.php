<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

/**
 * Class Enroll.
 *
 * @package namespace App\Entities;
 */
class Enroll extends Eloquent
{
    protected $guarded = [];

    public function getTypeLabel()
    {
        if (!$this->type) return '--';

        $typeLabels = [
            'demo_user_lead' => 'Android demo user lead',
            'lucky_coupon_lead' => 'Lucky coupon lead',
            'message_lead' => 'Web message lead',
            'hsl_message' => 'HSL website message',
        ];
        if (array_key_exists($this->type, $typeLabels)) {
            return $typeLabels[$this->type];
        }

        return '--'
;    }
}
