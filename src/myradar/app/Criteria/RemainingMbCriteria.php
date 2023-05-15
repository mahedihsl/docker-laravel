<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use App\Entities\Device;

/**
 * Class RemainingMbCriteria
 * @package namespace App\Criteria;
 */
class RemainingMbCriteria implements CriteriaInterface
{
    private $mb;

    public function __construct($mb)
    {
        $this->mb = $mb;
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
        $car_ids = Device::where('balance.remained', '<=', $this->mb)
                    ->get(['car_id'])
                    ->map(function($device) {
                        return $device->car_id;
                    })
                    ->toArray();

        return $model->whereIn('_id', $car_ids);
    }
}
