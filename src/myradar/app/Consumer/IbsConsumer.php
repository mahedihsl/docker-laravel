<?php

namespace App\Consumer;

use App\Entities\Device;
use App\Entities\Ibs;
use App\Criteria\DeviceIdCriteria;
use App\Criteria\ExactDateCriteria;
use App\Contract\Repositories\MileageRepository;

/**
 * @class IbsConsumer
 */
class IbsConsumer extends ServiceConsumer
{
    function __construct($data)
    {
        parent::__construct($data);
    }

    protected function transform($data)
    {
        return intval($data);
    }

    public function consume(Device $device)
    {
        Ibs::create([
			'device_id' => $device->id,
			'value' => $this->getData(),
		]);
    }
}
