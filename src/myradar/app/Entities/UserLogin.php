<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class UserLogin extends Eloquent
{
    protected $guarded = [];
  //  protected $dates = ['when'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
