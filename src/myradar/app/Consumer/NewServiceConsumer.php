<?php

namespace App\Consumer;

use Carbon\Carbon;
use App\Entities\Device;
use App\Events\AcStateChanged;
use App\Events\DoorStateChanged;

/**
 * @class NewServiceConsumer
 */
class NewServiceConsumer extends ServiceConsumer
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
        if ($this->getData() != $device->ns_state) {
            $service = $device->car->new_service;
            $device->update([ 'ns_state' => $this->getData() ]);
            if ($service == 1) {
                event(new AcStateChanged($device, $this->getData()));
            } else if ($service == 2) {
                event(new DoorStateChanged($device, $this->getData()));
            }
        }
    }
}
