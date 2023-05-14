<?php

namespace App\Contract\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;
use Illuminate\Support\Collection;
/**
 * Interface PromoCodeRepository.
 *
 * @package namespace App\Contract\Repositories;
 */
interface PromoCodeRepository extends RepositoryInterface
{
    public function save(Collection $data);
}
