<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Carbon\Carbon;

class PromoScheme extends Eloquent implements Transformable
{
    use TransformableTrait;

    protected $guarded = [];

    public function promo_codes()
    {
        return $this->hasMany(PromoCode::class);
    }


}
