<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Carbon\Carbon;
class CarStatusLog extends Eloquent
{
    protected $guarded = [];
    protected $dates = ['when'];

    public static $UNLOCK_ACTION = 0;
    public static $LOCK_ACTION = 1;
    public static $ENGINE_ON_ACTION = 2;
    public static $ENGINE_OFF_ACTION = 3;

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }



    public function getActionTypeNameAttribute()
    {
        $TYPE_NAME = [
            self::$UNLOCK_ACTION => 'Unlock',
            self::$LOCK_ACTION => 'Lock',
            self::$ENGINE_ON_ACTION => 'Engine ON',
            self::$ENGINE_OFF_ACTION => 'Engine OFF',
        ];

        return isset($TYPE_NAME[$this->action_type]) ? $TYPE_NAME[$this->action_type] : '--';
    }


    public function createLog($before_lock_status,$before_engine_status,$after_lock_status,$after_engine_status,$action, $Device,$executed_by,$action_type=null)
    {
       $car_status_log = CarStatusLog::create([
       'device_id' => $Device->id,
       'car_id' =>$Device->car->id,
       'user_id' => $Device->user->id,
       'before.lock_status'=> $before_lock_status,
       'before.engine_status'=> $before_engine_status,
       'after.lock_status'=>$after_lock_status,
       'after.engine_status'=>$after_engine_status,
       'executed_by'=>$executed_by,
       'when'=>Carbon::now(),
       'action_type'=>$action_type,
       'action'=>$action
     ]);
    }
}
