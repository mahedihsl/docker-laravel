<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\MetaDataRepository;
use App\Entities\MetaData;
use App\Validators\MetaDataValidator;

/**
 * Class MetaDataRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class MetaDataRepositoryEloquent extends BaseRepository implements MetaDataRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MetaData::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
