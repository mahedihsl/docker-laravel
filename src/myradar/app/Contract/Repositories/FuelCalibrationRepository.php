<?php

namespace App\Contract\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface FuelCalibrationRepository.
 *
 * @package namespace App\Contract\Repositories;
 */
interface FuelCalibrationRepository extends RepositoryInterface
{
    public function save($id, $data);
}
