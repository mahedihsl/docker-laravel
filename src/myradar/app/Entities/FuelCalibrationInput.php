<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class FuelCalibrationInput.
 *
 * @package namespace App\Entities;
 */
class FuelCalibrationInput extends Eloquent implements Transformable
{
  use TransformableTrait;
  protected $dates = ["time"];
  protected $guarded = [];

  public function car()
  {
    return $this->belongsTo(Car::class);
  }
}
