<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

use Carbon\Carbon;
use App\Entities\Device;

/**
 * Class CarBalanceValidityCriteria
 * @package namespace App\Criteria;
 */
class CarBalanceValidityCriteria implements CriteriaInterface
{
    /**
     * @var Carbon
     */
    private $date;

    public function __construct(Carbon $date)
    {
        $this->date = $date;
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
        $car_ids = Device::where('balance.validity', '<=', $this->date->timestamp)
                    ->get(['car_id'])
                    ->map(function($device) {
                        return $device->car_id;
                    })
                    ->toArray();

        return $model->whereIn('_id', $car_ids);
    }
}
