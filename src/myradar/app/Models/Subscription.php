<?php

namespace App\Models;
use App\Entities\Service;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Subscription extends Eloquent
{
    protected $guarded = [];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }


    public function service() {

        return $this->belongsTo(Service::class);

    }



}
