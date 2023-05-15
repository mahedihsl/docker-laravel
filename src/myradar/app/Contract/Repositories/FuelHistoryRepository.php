<?php

namespace App\Contract\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

use App\Entities\Device;

/**
 * Interface FuelHistoryRepository
 * @package namespace App\Contract\Repositories;
 */
interface FuelHistoryRepository extends RepositoryInterface
{
    public function save(Device $device, $value);
}
