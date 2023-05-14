<?php

namespace App\Consumer;

use Carbon\Carbon;
use App\Entities\Device;
use App\Events\AcStatusChanged;

/**
 * @class AcStatusConsumer
 */
class AcStatusConsumer extends ServiceConsumer
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
        if ($device->ac_status != $this->getData()) {
            $device->update(['ac_status' => $this->getData()]);
            event(new AcStatusChanged($device, $this->getData()));
        }
    }
}
