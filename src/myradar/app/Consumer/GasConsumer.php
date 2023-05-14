<?php

namespace App\Consumer;

use App\Entities\Device;
use App\Events\GasReceived;
use App\Contract\Repositories\GasHistoryRepository;
use App\Criteria\ExactDateCriteria;
use Carbon\Carbon;

/**
 * @class GasConsumer
 */

class GasConsumer extends ServiceConsumer
{
    /**
     * @var GasHistoryRepository
     */
    private $repository;

    function __construct($data)
    {
        parent::__construct($data);

        $this->repository = resolve(GasHistoryRepository::class);
    }

    protected function transform($data)
    {
        return intval($data);
    }

    public function consume(Device $device)
    {
        if(!$device->car) return;
        $status = $device->engine_status;
        if ($status) {
            $record = $this->repository->save($device, $this->getData());
            $gasMin = is_null($device->meta['gas_min']) ? config('car.meter.gas.min') : $device->meta['gas_min'];
            if ($this->getData() > $gasMin) {
                $meter = $device->meter;
                while ($meter->get('gas')->count() >= config('car.meter.gas.count')) {
                    $meter->get('gas')->shift();
                }

                $newGasCount = $device->car->meta_data['cng_type'] == 1 ? config('car.refuelByFiltering.gas.minBatchSize') : config('car.refuelByFiltering.gas.minBatchSize2') ;

                while ($meter->get('newGas')->count() >= $newGasCount) {
                    $meter->get('newGas')->shift();
                }

                $meter->get('gas')->push($this->getData());
                $meter->get('newGas')->push($this->getData());
                $device->meter = $meter;
                $device->save();

                event(new GasReceived($device, $record));
            }
        }
    }
}
