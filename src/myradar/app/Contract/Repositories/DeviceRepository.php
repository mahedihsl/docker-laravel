<?php

namespace App\Contract\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ThanaRepository
 * @package namespace App\Contract\Repositories;
 */
interface DeviceRepository extends RepositoryInterface
{
    public function save($comId, $phone, $version, $imei);

    public function updateByCriteria($attributes);

    public function count();
}
