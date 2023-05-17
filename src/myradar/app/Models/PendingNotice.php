<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PendingNotice.
 *
 * @package namespace App\Entities;
 */
class PendingNotice extends Eloquent implements Transformable
{
    use TransformableTrait;

    protected $guarded = [];

}
