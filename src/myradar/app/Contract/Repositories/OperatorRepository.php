<?php

namespace App\Contract\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

use Illuminate\Support\Collection;

/**
 * Interface OperatorRepository
 * @package namespace App\Contract\Repositories;
 */
interface OperatorRepository extends RepositoryInterface
{
    public function change(Collection $data);
}
