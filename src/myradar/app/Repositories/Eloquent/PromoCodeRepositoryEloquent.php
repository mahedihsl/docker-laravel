<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\PromoCodeRepository;
use App\Entities\PromoCode;
use App\Validators\PromoCodeValidator;
use Illuminate\Support\Collection;
/**
 * Class PromoCodeRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class PromoCodeRepositoryEloquent extends BaseRepository implements PromoCodeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PromoCode::class;
    }

    public function save(Collection $data)
    {
        $promocode = $this->create([
            'code' => $data->get('code'),
            'user_id' => $data->get('user_id'),
            'promo_scheme_id' => $data->get('promo_scheme_id'),
        ]);

        return $promocode;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
