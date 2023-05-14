<?php

namespace App\Contract\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

use App\Entities\Device;

/**
 * Interface PositionRepository
 * @package namespace App\Contract\Repositories;
 */
interface PositionRepository extends RepositoryInterface
{
    public function save(Device $device, $lat, $lng, $when = null);
}
