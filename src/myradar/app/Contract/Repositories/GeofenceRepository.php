<?php

namespace App\Contract\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

use Illuminate\Support\Collection;
use App\Entities\User;

/**
 * Interface FenceRepository
 * @package namespace App\Contract\Repositories;
 */
interface GeofenceRepository extends RepositoryInterface
{
    public function save(Collection $data, User $user);

    public function ofUser($userId);
}
