<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\UserRepository;
use Illuminate\Support\Collection;
use App\Entities\User;
use App\Events\CustomerCreated;

/**
 * Class UserRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    public function withTrashed()
    {
        $this->model = $this->model->withTrashed();
        return $this;
    }

    public function saveCustomer(Collection $data) {
        return $this->create([
            'name' => $data->get('name'),
            'phone' => $data->get('phone'),
            'nid' => '',
            'address' => $data->get('address'),
            'email' => $data->get('email'),
            'password' => bcrypt($data->get('password')),
            'api_token' => str_random(60),
            'type' => User::$TYPE_CUSTOMER,
            'customer_type' => intval($data->get('ctype')),
            'note' => '',
        ]);
    }

    public function updateCustomer($id, Collection $data)
    {
        $props = [
            'name' => $data->get('name'),
			'address' => $data->get('address'),
            'nid' => $data->get('nid'),
            'email' => $data->get('email'),
            'customer_type' => intval($data->get('type')),
            'ref_no' => $data->get('ref_no'),
            'status' => $data->get('status'),
        ];
        if ($data->has('phone')) {
            $props['phone'] = $data->get('phone');
        }
        return $this->update($props, $id);
    }

    public function saveUser(Collection $data)
    {
        return $this->create([
            'name' => $data->get('name'),
            'phone' => $data->get('phone'),
            'nid' => $data->get('nid'),
            'email' => $data->get('email'),
            'password' => bcrypt($data->get('password')),
            'type' => $data->get('type'),
            'note' => '',
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
