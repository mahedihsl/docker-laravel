<?php

namespace App\Contract\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

use App\Entities\Device;

/**
 * Interface GasHistoryRepository
 * @package namespace App\Contract\Repositories;
 */
interface GasHistoryRepository extends RepositoryInterface
{
    public function save(Device $device, $value);
}
