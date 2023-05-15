<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class demoLocation extends Eloquent
{
    protected $guarded = [];
    protected $table='demo_locations';
}
