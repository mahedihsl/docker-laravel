<?php

namespace App\Listeners;

use App\Events\SpeedLimitCrossEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Entities\Event;
use App\Contract\Repositories\EventRepository;

class StoreSpeedEvent
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
     * @param  SpeedLimitCrossEvent  $event
     * @return void
     */
    public function handle(SpeedLimitCrossEvent $event)
    {
        if ($event->flag) {
            $data = collect([
                'title' => $event->title(),
                'body' => $event->body(),
            ]);
            $this->repository->save($event->device, $data, Event::TYPE_SPEED);
        }
    }
}
