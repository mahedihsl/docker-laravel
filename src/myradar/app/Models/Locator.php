<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Locator extends Eloquent
{
    protected $guarded = [];
    protected $dates = ['start_time','end_time'];


}
