<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\MessageRepository;
use App\Entities\Message;
use Illuminate\Support\Collection;

/**
 * Class MessageRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class MessageRepositoryEloquent extends BaseRepository implements MessageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Message::class;
    }

    public function save(Collection $data)
    {
        return $this->create([
            'name' => $data->get('name', ''),
            'phone' => $data->get('phone'),
            'email' => $data->get('email', ''),
            'body' => $data->get('message'),
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
