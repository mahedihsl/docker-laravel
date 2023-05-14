<?php

namespace App\Contract\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

use App\Entities\Device;

/**
 * Interface MileageRepository
 * @package namespace App\Contract\Repositories;
 */
interface MileageRepository extends RepositoryInterface
{
    public function save(Device $device, $value);
}
