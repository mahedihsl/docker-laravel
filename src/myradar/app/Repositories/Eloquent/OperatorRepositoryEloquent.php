<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\OperatorRepository;
use App\Entities\Operator;

use Illuminate\Support\Collection;

/**
 * Class OperatorRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class OperatorRepositoryEloquent extends BaseRepository implements OperatorRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Operator::class;
    }

    public function change(Collection $data)
    {
        return $this->update([
            'name' => $data->get('name'),
            'ussd' => $data->get('ussd'),
            'start' => $data->get('start'),
            'sender' => $data->get('sender'),
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
