<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\NoticeRepository;
use App\Entities\Notice;
use App\Validators\NoticeValidator;

/**
 * Class NoticeRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class NoticeRepositoryEloquent extends BaseRepository implements NoticeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Notice::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
