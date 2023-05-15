<?php

namespace App\Listeners;

use App\Events\FenceAttached;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Contract\Repositories\FenceLogRepository;
use App\Criteria\CarIdCriteria;
use App\Criteria\FenceIdCriteria;

class UpdateFenceLog
{
    /**
     * @var FenceLogRepository;
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
     * @param  FenceAttached  $event
     * @return void
     */
    public function handle(FenceAttached $event)
    {
        $this->repository->pushCriteria(new CarIdCriteria($event->car->id));
        $this->repository->pushCriteria(new FenceIdCriteria($event->fence->id));

        if (is_null($this->repository->first())) {
            $this->repository->create([
                'car_id' => $event->car->id,
                'fence_id' => $event->fence->id,
            ]);
        }
    }
}
