<?php

namespace App\Listeners;

use App\Events\FenceCrossEvent;
use App\Contract\Repositories\TripRepository;
use App\Entities\Fence;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;

class CheckTripOver
{

    /**
     * @var TripRepository
     */
    private $repository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->repository = resolve(TripRepository::class);
    }

    /**
     * Handle the event.
     *
     * @param  FenceCrossEvent  $event
     * @return void
     */
    public function handle(FenceCrossEvent $event)
    {
        if ( ! $event->isTypeBus() ||
             ! $event->flag ||
             is_null($event->device->meta->get('fence_out')) ) {
            return;
        }

        $fence_out = $event->device->meta->get('fence_out');
        if ($event->fence->id != $fence_out['id']) {

            $out_name = '...';
            if (isset($fence_out['name'])) {
                $out_name = $fence_out['name'];
            } else {
                $out_name = Fence::find($fence_out['id'])->name;
            }

            $this->repository->create([
                'car_id' => $event->device->car_id,
                'start' => Carbon::createFromTimestamp($fence_out['time']),
                'start_at' => $out_name,
                'finish' => Carbon::now(),
                'finish_at' => $event->fence->name,
            ]);
        }
    }
}
