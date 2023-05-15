<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\EventRepository;
use App\Presenters\EventPresenter;
use App\Entities\Event;

/**
 * Class EventRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class EventRepositoryEloquent extends BaseRepository implements EventRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Event::class;
    }

    public function presenter()
    {
        return EventPresenter::class;
    }

    public function save($device, $data, $type, $mode = Event::MODE_PUBLIC)
    {
        return $this->skipPresenter()->create([
            'title'     => $data->get('title'),
            'body'      => $data->get('body'),
            'type'      => $type,
            'mode'      => $mode,
            'meta'      => $data->has('meta') ? $data->get('meta') : [],
            'car_id'    => $device->car_id,
            'user_id'   => $device->user_id,
        ]);
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
