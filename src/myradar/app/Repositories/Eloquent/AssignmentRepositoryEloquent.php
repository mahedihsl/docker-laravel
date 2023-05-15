<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\AssignmentRepository;
use App\Entities\Assignment;
use App\Validators\AssignmentValidator;
use App\Presenters\AssignmentPresenter;
use Illuminate\Support\Collection;
use Carbon\Carbon;

/**
 * Class AssignmentRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class AssignmentRepositoryEloquent extends BaseRepository implements AssignmentRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Assignment::class;
    }

    public function save(Collection $data)
    {
        $type       = intval($data->get('type'));
        $from       = Carbon::createFromFormat('j M Y h:i A', $data->get('when'));
        $to         = $from->copy()->addHours(intval($data->get('duration')));
        $message    = $type != Assignment::TYPE_EMPLOYEE ? $data->get('message') : null;
        $employee_id = $type == Assignment::TYPE_EMPLOYEE ? $data->get('employee_id') : null;

        return $this->skipPresenter()->create([
            'driver_id'     => $data->get('driver_id'),
            'employee_id'   => $employee_id,
            'car_id'        => $data->get('car_id'),
            'user_id'       => $data->get('user_id'),
            'message'       => $message,
            'start'         => $data->get('start'),
            'dest'          => $data->get('dest'),
            'type'          => $type,
            'status'        => Assignment::STATUS_ACTIVE,
            'from'          => $from,
            'to'            => $to,
        ]);
    }

    public function presenter()
    {
        return AssignmentPresenter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
