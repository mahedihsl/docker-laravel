<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class UserLoginHistory extends Eloquent
{
  protected $guarded = [];
  protected $dates = ['ios.logout_at','android.logout_at','web.logout_at','ios.login_at','web.login_at','android.login_at'];
  public static $IOS_DEVICE_TYPE=1;
  public static $ANDROID_DEVICE_TYPE=0;

  public function user()
  {
      return $this->belongsTo(User::class);
  }
}
