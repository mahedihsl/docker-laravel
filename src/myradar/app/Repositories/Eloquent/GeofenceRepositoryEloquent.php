<?php

namespace App\Repositories\Eloquent;

use Illuminate\Support\Collection;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\GeofenceRepository;
use App\Entities\User;
use App\Entities\Geofence;
// use App\Presenters\FencePresenter;

/**
 * Class FenceRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class GeofenceRepositoryEloquent extends BaseRepository implements GeofenceRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Geofence::class;
    }

    public function save(Collection $data, User $user)
    {
        $props = [
            'name' => $data->get('name'),
            'vertices' => [
                'type' => 'Polygon',
                'coordinates' => $data->get('coordinates'),
            ]
        ];
        if (!$user->isCustomer()) {
            $props['type'] = 'template';
        } else {
            $props['user_id'] = $user->id;
        }
        return $this->create($props);
    }

    public function ofUser($userId)
    {
        return $this->scopeQuery(function($query) use ($userId) {
            return $query->where('user_id', $userId)
                ->orderBy('created_at', 'desc');
        })->get();
    }

    public function templates()
    {
        return $this->scopeQuery(function($query) {
            return $query->where('type', 'template')
                ->orderBy('created_at', 'desc');
        })->get();
    }

    public function attachTemplate($templateId, $userId)
    {
        $user = User::find($userId);
        $template = Geofence::find($templateId);

        $props = [
            'user_id' => $user->id,
            'name' => $template->name,
            'vertices' => $template->vertices,
        ];
        return $this->create($props);
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
