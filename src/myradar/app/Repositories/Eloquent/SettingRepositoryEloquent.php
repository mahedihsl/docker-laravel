<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\SettingRepository;
use App\Entities\User;
use App\Entities\Car;
use App\Entities\Setting;
use Illuminate\Support\Collection;

/**
 * Class SettingRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class SettingRepositoryEloquent extends BaseRepository implements SettingRepository
{
    private $attributes = [
        'noti_engine',
        'noti_geofence',
        'noti_date',
        'noti_speed',
        'sms_pack1',
        'sms_pack2',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Setting::class;
    }

    public function save(User $user)
    {
        return $this->create([
            'noti_engine'   => TRUE,
            'noti_geofence' => FALSE,
            'noti_date'     => FALSE,
            'noti_speed'    => FALSE,
            'user_id'       => $user->id,
        ]);
    }

    public function enterSave(User $user, Car $car)
    {
        return $this->create([
            'noti_engine'   => TRUE,
            'noti_geofence' => FALSE,
            'noti_date'     => FALSE,
            'noti_speed'    => FALSE,
            'user_id'       => $user->id,
            'car_id'        => $car->id,
        ]);
    }
    public function change($id, Collection $data)
    {
        $filter = collect();
        foreach ($this->attributes as $index => $key) {
            if($data->has($key)) {
                $filter->put($key, boolval($data->get($key)));
            }
        }
        $this->update($filter->toArray(), $id);
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
