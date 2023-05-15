<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\EmployeeRepository;
use App\Entities\Employee;
use App\Presenters\EmployeePresenter;
use Illuminate\Support\Collection;

/**
 * Class EmployeeRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class EmployeeRepositoryEloquent extends BaseRepository implements EmployeeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Employee::class;
    }

    public function presenter()
    {
        return EmployeePresenter::class;
    }

    public function save(Collection $data)
    {
        return $this->create([
            'name'      => $data->get('name'),
            'phone'     => $data->get('phone'),
            'user_id'   => $data->get('user_id'),
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
