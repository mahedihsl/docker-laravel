<?php

namespace App\Repositories\Eloquent;

use Illuminate\Support\Collection;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\FenceRepository;
use App\Entities\Car;
use App\Entities\Fence;
use App\Presenters\FencePresenter;

/**
 * Class FenceRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class FenceRepositoryEloquent extends BaseRepository implements FenceRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Fence::class;
    }

    public function presenter()
    {
        return FencePresenter::class;
    }

    public function save(Car $car, Collection $data)
    {
        return $this->create([
            'name' => $data->get('name'),
            'lat' => $data->get('lat'),
            'lng' => $data->get('lng'),
            'radius' => $data->get('radius'),
            'car_id' => $car->id,
        ]);
    }

    public function change(Collection $data)
    {
        # code...
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
