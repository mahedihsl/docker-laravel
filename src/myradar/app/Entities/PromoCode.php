<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Carbon\Carbon;
use App\Entities\PromoScheme;
use App\Entities\User;

/**
 * Class PromoCode.
 *
 * @package namespace App\Entities;
 */

class PromoCode extends Eloquent implements Transformable
{
    use TransformableTrait;
    protected $guarded=[];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    public function getAppliedAttribute($value)
    {
      return is_array($value) ? $value : [];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function promo_scheme()
    {
        return $this->belongsTo(PromoScheme::class);
    }
}
