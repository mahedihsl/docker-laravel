<?php

namespace App\Contract\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;
use Illuminate\Support\Collection;

/**
 * Interface MessageRepository.
 *
 * @package namespace App\Contract\Repositories;
 */
interface MessageRepository extends RepositoryInterface
{
    public function save(Collection $data);
}
