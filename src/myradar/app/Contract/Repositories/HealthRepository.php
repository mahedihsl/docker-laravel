<?php

namespace App\Contract\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

use App\Entities\Device;
use Illuminate\Support\Collection;

/**
 * Interface HealthRepository
 * @package namespace App\Contract\Repositories;
 */
interface HealthRepository extends RepositoryInterface
{
    public function save(Device $device, Collection $data);

    public function change(Collection $data);

    public function count();
}
