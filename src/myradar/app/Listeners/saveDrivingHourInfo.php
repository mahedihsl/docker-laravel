<?php

namespace App\Listeners;

use App\Events\getDrivingHour;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Entities\DrivingHour;
use App\Entities\Position;
use Carbon\Carbon;

class saveDrivingHourInfo
{
    /**
     * Create the event listener.
     *
     * @return void
     */

    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  getDrivingHour  $event
     * @return void
     */
    public function handle(getDrivingHour $event)
    {
        $data = json_decode($event->event_value, true);

        $car_id = $data['car_id'];
        $device_id = $data['device_id'];

        $get_last_position = Position::where('device_id', $device_id)
                                ->orderBy('created_at', 'desc')
                               ->first();
        $max_wait = 60;
        $timestamp_now = Carbon::now()->timestamp;
        $time_diff = $timestamp_now-$get_last_position->when->timestamp;
        $driving_hour = DrivingHour::where('device_id', $device_id)->where('when', '=', Carbon::today())->first();

        if (is_null($driving_hour)) {
              $create = DrivingHour::create([
               'car_id' => $car_id,
               'device_id' => $device_id,
               'when' => Carbon::today(),
               'value' =>$time_diff
              ]);

        } else {
            if ($time_diff <$max_wait) {//seconds
               $driving_hour->when = Carbon::today();
               $driving_hour->value = $driving_hour->value+$time_diff;
               $driving_hour->save();
            }
        }
    }
}
