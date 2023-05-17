<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ServiceLog extends Eloquent
{
    protected $guarded = [];
    protected $dates = ['when'];
    public static $waiting = 2;//int-ops team will wait this time(mintues ) to confirm that services are recieved correctly

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    // public function getServiceAttribute() {
    //     return Service::where('sid', $this->service_id)->first();
    //
    // }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
