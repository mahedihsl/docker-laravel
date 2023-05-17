<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use App\Entities\Car;

class GasRefuelInput extends Eloquent
{
    protected $dates = ["time"];
    protected $guarded = [];

    public function event()
    {
      return $this->belongsTo(Event::class);
    }

    public function car()
    {
      return $this->belongsTo(Car::class);
    }
}
