<?php
namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class District extends Eloquent implements Transformable
{
    use TransformableTrait;

    protected $guarded = [];

    public function thanas()
    {
        return $this->hasMany(Thana::class);
    }

}
