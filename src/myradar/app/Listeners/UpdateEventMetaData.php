<?php

namespace App\Listeners;

use App\Events\EngineStatusChanged;
use App\Contract\Repositories\EventRepository;
use App\Criteria\CarIdCriteria;
use App\Criteria\ModelTypeCriteria;
use App\Criteria\LastCreatedCriteria;
use App\Entities\Event;
use App\Entities\Device;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateEventMetaData
{
    /**
     * @var EventRepository
     */
    private $repository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(EventRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle the event.
     *
     * @param  EngineStatusChanged  $event
     * @return void
     */
    public function handle(EngineStatusChanged $event)
    {
        if ($event->status === 1) {
            $this->onCarStart($event->device);
        } else {
            $this->onCarOff($event->device, $event->silent);
        }
    }

    private function onCarStart($device)
    {
        // TODO: save controller session time &
        // shield reset count in event meta data
    }

    private function onCarOff($device, $silent)
    {
      try {
        $model = $this->getLatestEvent($device, Event::TYPE_OFF);

        if ( ! is_null($model)) {
            $lastOn = $this->getLatestEvent($device, Event::TYPE_ON);

            if ( ! $lastOn || ! $lastOn->cache) return;

            $arr = [
                'lat' => $lastOn->cache['lat'],
                'gas' => $lastOn->cache['gas'],
                'fuel' => $lastOn->cache['fuel'],
                'mileage_wf' => round($lastOn->cache['wf']['mil'], 2),
                'mileage_wof' => round($lastOn->cache['wof']['mil'], 2),

            ];

            if ($silent === TRUE) {
                $arr['background'] = 'TRUE';
            }

            $model->update([ 'meta' => $arr ]);
        }
      } catch (\Exception $e) {

      }


    }

    public function getLatestEvent(Device $device, $type)
    {
        return $this->repository
                    ->resetCriteria()
                    ->skipPresenter()
                    ->pushCriteria(new CarIdCriteria($device->car_id))
                    ->pushCriteria(new ModelTypeCriteria($type))
                    ->pushCriteria(new LastCreatedCriteria())
                    ->first();
    }

}
