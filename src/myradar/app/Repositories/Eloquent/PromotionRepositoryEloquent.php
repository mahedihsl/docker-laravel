<?php

namespace App\Repositories\Eloquent;

use Illuminate\Support\Collection;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\PromotionRepository;
use App\Entities\PromoScheme;
use Carbon\Carbon;

/**
 * Class PaymentRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class PromotionRepositoryEloquent extends BaseRepository implements PromotionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PromoScheme::class;
    }

    public function save(Collection $data)
    {
        $promoscheme = $this->create([
            'name' => $data->get('name'),
            'free_month' => intval($data->get('freeMonth')),
            'discount' => intval($data->get('discount')),
            'valid_till' => Carbon::createFromTimestamp(intval($data->get('date')))->format('d M Y'),
        ]);

        return $promoscheme;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
