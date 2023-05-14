<?php

namespace App\Listeners;

use App\Events\EngineStatusChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Contract\Repositories\DutyHourRepository;
use App\Criteria\DeviceIdCriteria;
use App\Criteria\ExactDateCriteria;
use Carbon\Carbon;

class UpdateDutyHour
{
    /**
     * @var DutyHourRepository
     */
    private $repository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(DutyHourRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle the event.
     *
     * @param  EngineStatusChanged  $event
     * @return void
     */
     public function transformedDate() //conversion for making day 3AM to 3AM
     {
       $date = Carbon::now()->subHours(3);
       $date->hour = 0;
       $date->minute = 0;
       $date->second = 0;

       return $date;
     }
    public function handle(EngineStatusChanged $event)
    {
        $offset = 3; //calculate day from 3AM to 3AM

        $model = $this->repository
                        ->pushCriteria(new DeviceIdCriteria($event->device->id))
                        ->pushCriteria(new ExactDateCriteria($this->transformedDate()))
                        ->first();

        if (is_null($model)) {
            $model = $this->repository->create([
                'start'     => null,
                'finish'    => null,
                'duration'  => 0,
                'when'      => $this->transformedDate(),
                'car_id'    => $event->device->car_id,
                'device_id' => $event->device->id,
            ]);
        }

        if ($event->status && is_null($model->start)) {
            $model->update(['start' => Carbon::now()]);
        } else {
            if (is_null($model->start)) {
                $model->update(['start' => Carbon::today()->addHours($offset)]);
                $this->updateYesterdayRecord($event->device);
            }
            $start = is_null($model->start) ? Carbon::today()->addHours($offset) : $model->start;
            $diff = $start->diffInMinutes(Carbon::now());
            $model->update([
                'finish' => Carbon::now(),
                'duration' => $diff,
            ]);
        }
    }

    public function updateYesterdayRecord($device)
    {
        $offset = 3; //calculate day from 3AM to 3AM

        $model = $this->repository->resetCriteria()
                        ->pushCriteria(new DeviceIdCriteria($device->id))
                        ->pushCriteria(new ExactDateCriteria(Carbon::yesterday()))
                        ->first();

        if ( ! is_null($model) && ! is_null($model->start)) {
            $diff = $model->start->diffInMinutes(Carbon::today()->addHours($offset));
            $model->update([
                'finish' => Carbon::today()->addHours($offset),
                'duration' => $diff,
            ]);
        }
    }
}
