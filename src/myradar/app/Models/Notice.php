<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Notice.
 *
 * @package namespace App\Entities;
 */
class Notice extends Eloquent implements Transformable
{
    use TransformableTrait;

    protected $guarded = [];

    public function getPendingCount()
    {
        return is_null($this->pending) ? -1 : $this->pending;
    }

    public function getSentCount()
    {
        return is_null($this->sent) ? -1 : $this->sent;
    }

    public function getFailedCount()
    {
        return is_null($this->failed) ? -1 : $this->failed;
    }

}
