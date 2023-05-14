<?php

namespace App\Listeners;

use App\Events\FenceDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Criteria\CarIdCriteria;
use App\Criteria\FenceIdCriteria;
use App\Contract\Repositories\FenceLogRepository;

class DeleteFenceLog
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
     * @param  FenceDeleted  $event
     * @return void
     */
    public function handle(FenceDeleted $event)
    {
        $this->repository->skipPresenter();
        $this->repository->pushCriteria(new CarIdCriteria($event->car->id));
        $this->repository->pushCriteria(new FenceIdCriteria($event->fence->id));

        $record = $this->repository->first();
        if ( ! is_null($record)) {
            $record->delete();
        }
    }
}
