<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class demoLocation extends Eloquent
{
    protected $guarded = [];
    protected $table='demo_locations';
}
