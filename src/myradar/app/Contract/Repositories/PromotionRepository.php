<?php

namespace App\Contract\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

use Illuminate\Support\Collection;

/**
 * Interface PromotionRepository
 * @package namespace App\Contract\Repositories;
 */
interface PromotionRepository extends RepositoryInterface
{
    public function save(Collection $data);
}
