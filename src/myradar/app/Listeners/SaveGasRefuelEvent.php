<?php

namespace App\Listeners;

use App\Events\GasRefueled;
use App\Contract\Repositories\EventRepository;
use App\Entities\Event;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SaveGasRefuelEvent
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
     * @param  GasRefueled  $event
     * @return void
     */
    public function handle(GasRefueled $event)
    {
        $mode = $event->isPublic() ? Event::MODE_PUBLIC : Event::MODE_PRIVATE;
        $data = collect([
            'title' => $event->title(),
            'body' => $event->body(),
            'meta' => [
                'magnitude' => $event->magnitude,
                'base' => $event->peakval
            ]
        ]);
        $model = $this->repository->save($event->device, $data, Event::TYPE_REFUEL, $mode);
    }
}
