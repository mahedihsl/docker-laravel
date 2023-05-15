<?php

namespace App\Contract\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

use Illuminate\Support\Collection;
use App\Entities\Car;

/**
 * Interface FenceRepository
 * @package namespace App\Contract\Repositories;
 */
interface FenceRepository extends RepositoryInterface
{
    public function save(Car $car, Collection $data);

    public function change(Collection $data);
}
