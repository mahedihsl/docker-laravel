<?php

namespace App\Listeners;

use App\Events\FenceCrossEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Entities\Event;
use App\Contract\Repositories\EventRepository;

class StoreGeoFenceEvent
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
     * @param  FenceCrossEvent  $event
     * @return void
     */
    public function handle(FenceCrossEvent $event)
    {
        $data = collect([
            'title' => $event->getTitle(),
            'body' => $event->getBody(),
        ]);
        $this->repository->save($event->device, $data, Event::TYPE_GEOFENCE);
    }
}
