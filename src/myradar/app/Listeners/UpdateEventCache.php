<?php

namespace App\Listeners;

use App\Events\ServiceStringReceived;
use App\Contract\Repositories\EventRepository;
use App\Entities\Event;
use App\Entities\Device;
use App\Criteria\CarIdCriteria;
use App\Criteria\ModelTypeCriteria;
use App\Criteria\LastUpdatedCriteria;
use App\Criteria\LastCreatedCriteria;
use App\Service\DirectionService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateEventCache
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
     * @param  ServiceStringReceived  $event
     * @return void
     */
    public function handle(ServiceStringReceived $event)
    {
        $model = $this->getLastOnEvent($event->device);

        if ( ! is_null($model)) {
            $carry = $model->cache;
            $wof = $this->wofResult($carry['wof'], $event->device->meta['pos']);
            $wf = $this->wfResult($carry['wf'], $event->device->meta['pos']);

            $model->update([
                'cache' => [
                    'lat' => $carry['lat'] + $event->positionCount(),
                    'gas' => $carry['gas'] + $event->gasCount(),
                    'fuel' => $carry['fuel'] + $event->fuelCount(),
                    'wof' => $wof,
                    'wf' => $wf,
                    //'nwf' => $nwf,
                ]
            ]);
        }
    }

    public function getLastOnEvent(Device $device)
    {
        return $this->repository
                    ->skipPresenter()
                    ->pushCriteria(new CarIdCriteria($device->car_id))
                    ->pushCriteria(new ModelTypeCriteria(Event::TYPE_ON))
                    ->pushCriteria(new LastCreatedCriteria())
                    ->first();
    }

    public function wofResult($carry, $latestPos)
    {
        if ( ! $latestPos) {
            return [
                'pos' => null,
                'mil' => 0,
            ];
        }

        if ( ! $carry['pos']) {
            return [
                'pos' => $latestPos,
                'mil' => 0,
            ];
        }

        $dist = (new DirectionService())->distance(
                $carry['pos']['lat'], $carry['pos']['lng'],
                $latestPos['lat'], $latestPos['lng']
            );
        return [
            'pos' => $latestPos,
            'mil' => $carry['mil'] + $dist,
        ];
    }

    public function wfResult($carry, $latestPos)
    {
        if ( ! $latestPos) {
            return [
                'pos' => null,
                'mil' => 0,
            ];
        }

        if ( ! $carry['pos']) {
            return [
                'pos' => $latestPos,
                'mil' => 0,
            ];
        }

        $thresold = config('car.mileage.position.diff');
        $dist = (new DirectionService())->distance(
                $carry['pos']['lat'], $carry['pos']['lng'],
                $latestPos['lat'], $latestPos['lng']
            );
        if ($dist <= $thresold) {

            return [
              'pos' => $latestPos,
              'mil' => $carry['mil'],
            ];
        }

        return [
            'pos' => $latestPos,
            'mil' => $carry['mil'] + $dist,
        ];
    }
    public function nWfResult($carry, $latestPos, Device $device)
    {
        if ( ! $latestPos) {
            return [
                'mil_pos' => null,
                'mil' => 0,
            ];
        }

        if ( ! $carry['mil_pos']) {
            return [
                'mil_pos' => $device->meta['mil_pos'],
                'mil' => 0,
            ];
        }

        $thresold = config('car.mileage.position.diff');
        $dist = (new DirectionService())->distance(
                $carry['mil_pos']['lat'], $carry['mil_pos']['lng'],
                $latestPos['lat'], $latestPos['lng']
            );
        if ($dist <= $thresold) {
            return $carry;
        }

        return [
            'mil_pos' => $latestPos,
            'mil' => $carry['mil'] + $dist,
        ];
    }
}
