<?php

namespace App\Consumer;

use Carbon\Carbon;
use App\Entities\Device;
use App\Criteria\DeviceIdCriteria;
use App\Criteria\ExactDateCriteria;
use App\Contract\Repositories\MileageRepository;

/**
 * @class DistanceConsumer
 */
class DistanceConsumer extends ServiceConsumer
{
    /**
     * @var MileageRepository
     */
    private $repository;

    function __construct($data)
    {
        parent::__construct($data);

        $this->repository = resolve(MileageRepository::class);
    }

    protected function transform($data)
    {
        /**
         * Multiply by 1.1 to increase the mileage 10%. Default mileage calculation has some problems.
         * Some user gets smaller mileage report
         */
        return intval($data * 1.1);
    }

    public function transformedDate() //conversion for making day 3AM to 3AM
    {
      $date = Carbon::now()->subHours(3);
      $date->hour = 0;
      $date->minute = 0;
      $date->second = 0;

      return $date;
    }

    public function consume(Device $device)
    {
        $record = $this->repository
                    ->skipPresenter()
                    ->pushCriteria(new DeviceIdCriteria($device->id))
                    ->pushCriteria(new ExactDateCriteria($this->transformedDate()))
                    ->first();

        if ( ! is_null($record)) {
            $record->increment('value', $this->getData());
            if ( ! $record->car_id) {
                $record->update(['car_id' => $device->car_id]);
            }
        } else {
            $this->repository->save($device, $this->getData());
        }
    }
}
