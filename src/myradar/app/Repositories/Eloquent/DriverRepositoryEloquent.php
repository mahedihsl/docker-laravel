<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\DriverRepository;
use App\Entities\Driver;
use App\Presenters\DriverPresenter;
use Illuminate\Support\Collection;

/**
 * Class DriverRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class DriverRepositoryEloquent extends BaseRepository implements DriverRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Driver::class;
    }

    public function presenter()
    {
        return DriverPresenter::class;
    }

    public function save(Collection $data)
    {
        return $this->create([
            'name' => $data->get('name'),
            'phone' => $data->get('phone'),
            'user_id' => $data->get('user_id'),
        ]);
    }

    public function change(Collection $data)
    {
        return $this->update([
            'name' => $data->get('name'),
            'phone' => $data->get('phone'),
        ], $data->get('id'));
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
