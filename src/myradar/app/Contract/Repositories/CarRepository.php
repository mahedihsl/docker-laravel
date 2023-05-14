<?php

namespace App\Contract\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;
use Illuminate\Support\Collection;

/**
 * Interface UserRepository
 * @package namespace App\Contract\Repositories;
 */
interface CarRepository extends RepositoryInterface
{
    public function save(Collection $data);

    public function change(Collection $data);

    public function updateDates($car, Collection $dates);
}
