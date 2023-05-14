<?php

namespace App\Listeners;

use App\Events\AcStateChanged;
use App\Contract\Repositories\EventRepository;
use App\Entities\Event;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class StoreAcEvent
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
     * @param  AcStateChanged  $event
     * @return void
     */
    public function handle(AcStateChanged $event)
    {
        $data = collect([
            'title' => $event->title(),
            'body' => $event->body(),
        ]);

        $this->repository->save($event->device, $data, Event::TYPE_AC);
    }
}
