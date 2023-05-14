<?php

namespace App\Listeners;

use App\Events\FuelRefueled;
use App\Contract\Repositories\EventRepository;
use App\Entities\Event;
use App\Entities\FuelGroup;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SaveFuelRefuelEvent
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
    public function handle(FuelRefueled $event)
    {
        $mode = $event->isPublic() ? Event::MODE_PUBLIC : Event::MODE_PRIVATE;
        $percentage = 0;
        $group = FuelGroup::where('tag', $event->device->car->fuel_group)->first();
        if ( ! is_null($group)) {
            $percentage = $group->findRefuelPercentage($event->magnitude);
        }
        $data = collect([
            'title' => $event->title(),
            'body' => $event->body(),
            'meta' => [
                'percentage' => $percentage,
                'magnitude' => $event->magnitude,
                'base' => $event->peakval
            ]
        ]);
        $model = $this->repository->save($event->device, $data, Event::TYPE_FUEL_REFUEL, $mode);
    }
}
