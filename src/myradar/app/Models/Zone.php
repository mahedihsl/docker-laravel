<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;

/**
 * Class Zone.
 *
 * @package namespace App\Entities;
 */
class Zone extends Eloquent implements Presentable
{
    use PresentableTrait;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
