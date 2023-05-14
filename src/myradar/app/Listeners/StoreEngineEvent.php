<?php

namespace App\Listeners;

use App\Events\EngineStatusChanged;
use App\Entities\Event;
use App\Contract\Repositories\EventRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;

class StoreEngineEvent
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
        if (is_null($event->device->car)) return;
        
        $data = $this->payload($event->device, $event->status);
        $this->repository->save($event->device, $data, $this->type($event->status));
    }

    public function payload($device, $status)
    {
        $label = $status ? 'ON' : 'OFF';
        $time = Carbon::now()->format('g:i A');

        return collect([
            'title' => "Alert for car: {$device->car->reg_no}",
            'body' => "Your car was {$label} at {$time}",
        ]);
    }

    private function type($status)
    {
        return $status ? Event::TYPE_ON : Event::TYPE_OFF;
    }
}
