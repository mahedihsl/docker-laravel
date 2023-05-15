<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\HealthRepository;
use App\Entities\Health;

use App\Entities\Device;
use Illuminate\Support\Collection;

/**
 * Class HealthRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class HealthRepositoryEloquent extends BaseRepository implements HealthRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Health::class;
    }

    public function save(Device $device, Collection $data)
    {
        return $this->create([
            'loop_count'    => intval($data->get('count_loop')),
            'setup_time'    => intval($data->get('time_setup')),
            'avg_loop_time' => intval($data->get('time_avg_loop')),
            'min_loop_time' => intval($data->get('time_min_loop')),
            'max_loop_time' => intval($data->get('time_max_loop')),
            'min_free_ram'  => intval($data->get('free_ram_min')),
            'max_free_ram'  => intval($data->get('free_ram_max')),
            'session_time'  => intval($data->get('session_time', '-1')),
            'shield_count'  => intval($data->get('shield_count', '-1')),
            'gps_power'     => intval($data->get('gps_power', '-1')),
            'cr'            => intval($data->get('cr', '-1')),
            'wr'            => intval($data->get('wr', '-1')),
            'es'            => intval($data->get('es', '-1')),
            'mcu'           => intval($data->get('mcu', '0')),
            'version'       => $data->get('v', '--'),
            'device_id'     => $device->id,
        ]);
    }

    public function change(Collection $data)
    {
        # code...
    }

    public function count()
    {
        return $this->model->count();
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
