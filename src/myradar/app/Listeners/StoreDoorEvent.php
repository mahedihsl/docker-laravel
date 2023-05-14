<?php

namespace App\Listeners;

use App\Events\DoorStateChanged;
use App\Contract\Repositories\EventRepository;
use App\Entities\Event;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class StoreDoorEvent
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
     * @param  DoorStateChanged  $event
     * @return void
     */
    public function handle(DoorStateChanged $event)
    {
        $data = collect([
            'title' => $event->title(),
            'body' => $event->body(),
        ]);

        $this->repository->save($event->device, $data, Event::TYPE_DOOR);
    }
}
