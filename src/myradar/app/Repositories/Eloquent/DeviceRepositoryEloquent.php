<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\DeviceRepository;
use App\Entities\Device;

/**
 * Class DeviceRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class DeviceRepositoryEloquent extends BaseRepository implements DeviceRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Device::class;
    }

    public function save($comId, $phone, $version, $imei)
    {
        return $this->create([
            'com_id' => $comId,
            'phone' => $phone,
            'system_status' => 0,
            'device_status' => 0,
            'engine_status' => 0,
            'lock_status' => 0,
            'car_id' => null,
            'user_id' => null,
            'version' => $version,
            'imei' => $imei,
        ]);
    }

    public function updateByCriteria($attributes)
    {
        $this->applyCriteria();
        $this->applyScope();

        $this->model->update($attributes);

        $this->resetModel();
        $this->resetScope();
    }

    public function count()
    {
        $this->applyCriteria();
        $this->applyScope();

        $ret = $this->model->count();

        $this->resetModel();
        $this->resetScope();

        return $ret;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
