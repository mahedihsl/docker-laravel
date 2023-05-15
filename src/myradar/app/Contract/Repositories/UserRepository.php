<?php

namespace App\Contract\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;
use Illuminate\Support\Collection;

/**
 * Interface UserRepository
 * @package namespace App\Contract\Repositories;
 */
interface UserRepository extends RepositoryInterface
{
    public function saveCustomer(Collection $data);

    public function updateCustomer($id, Collection $data);

    public function saveUser(Collection $data);
}
