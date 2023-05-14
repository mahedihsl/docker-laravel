<?php

namespace App\Contract\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;
use Illuminate\Support\Collection;

/**
 * Interface RefuelFeedRepository.
 *
 * @package namespace App\Contract\Repositories;
 */
interface RefuelFeedRepository extends RepositoryInterface
{
    public function save(Collection $data);
}
