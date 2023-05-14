<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\ZoneRepository;
use App\Entities\Zone;
use App\Presenters\ZonePresenter;
use Illuminate\Support\Collection;

/**
 * Class ZoneRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class ZoneRepositoryEloquent extends BaseRepository implements ZoneRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Zone::class;
    }

    public function presenter()
    {
        return ZonePresenter::class;
    }

    public function save(Collection $data)
    {
        return $this->skipPresenter()->create([
            'name'      => $data->get('name'),
            'lat'       => $data->get('lat'),
            'lng'       => $data->get('lng'),
            'radius'    => $data->get('radius'),
            'user_id'   => $data->get('user_id'),
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
