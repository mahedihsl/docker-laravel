<?php

namespace App\Listeners;

use App\Events\PanicStateTriggered;
use App\Entities\Event;
use App\Contract\Repositories\EventRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class StorePanicEvent
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
     * @param  PanicStateTriggered  $event
     * @return void
     */
    public function handle(PanicStateTriggered $event)
    {
        if ( ! $event->deliverable()) return;
        
        $data = collect([
            'title' => $event->title(),
            'body' => $event->body(),
        ]);

        $this->repository->save($event->device, $data, Event::TYPE_PANIC);
    }
}
