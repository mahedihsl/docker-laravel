<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class DeviceIdCriteria
 * @package namespace App\Criteria;
 */
class DeviceIdCriteria implements CriteriaInterface
{
    private $deviceId;

    public function __construct($deviceId)
    {
        $this->deviceId = $deviceId;
    }

    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('device_id', $this->deviceId);
    }
}
