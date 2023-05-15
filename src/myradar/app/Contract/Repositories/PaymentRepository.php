<?php

namespace App\Contract\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

use Illuminate\Support\Collection;

/**
 * Interface PaymentRepository
 * @package namespace App\Contract\Repositories;
 */
interface PaymentRepository extends RepositoryInterface
{
    public function save(Collection $data);
}
