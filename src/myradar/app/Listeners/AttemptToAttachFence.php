<?php

namespace App\Listeners;

use App\Events\FenceCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Contract\Repositories\FenceLogRepository;

class AttemptToAttachFence
{
    /**
     * @var FenceLogRepository
     */
    private $repository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(FenceLogRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle the event.
     *
     * @param  FenceCreated  $event
     * @return void
     */
    public function handle(FenceCreated $event)
    {
        $this->repository->create([
            'fence_id' => $event->fence->id,
            'car_id' => $event->car->id,
        ]);

        $ids = $event->car->fence_ids ?: [];

        if (sizeof($ids) < config('car.fence.limit')) {
            $event->car->fences()->attach($event->fence->id);
        }
    }
}
