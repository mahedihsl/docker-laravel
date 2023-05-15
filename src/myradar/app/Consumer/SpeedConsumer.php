<?php

namespace App\Consumer;

use App\Entities\Device;
use App\Events\SpeedLimitCrossEvent;

/**
 * @class SpeedConsumer
 */
class SpeedConsumer extends ServiceConsumer
{

    function __construct($data)
    {
        parent::__construct($data);
    }

    protected function transform($data)
    {
        return collect(explode(',', $data));
    }

    public function consume(Device $device)
    {
        $limit = $this->getData()->get(0);
        $flag = $this->getData()->get(1);

        if (intval($limit) > 30) {
            event(new SpeedLimitCrossEvent($device, $limit, $flag));
        }
    }
}
