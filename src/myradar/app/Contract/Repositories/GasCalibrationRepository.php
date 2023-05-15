<?php

namespace App\Contract\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface GasCalibrationRepository.
 *
 * @package namespace App\Contract\Repositories;
 */
interface GasCalibrationRepository extends RepositoryInterface
{
    public function save($id, $data);
}
