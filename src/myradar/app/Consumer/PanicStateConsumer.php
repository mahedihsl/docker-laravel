<?php

namespace App\Consumer;

use Carbon\Carbon;
use App\Entities\Device;
use App\Events\PanicStateTriggered;

/**
 * @class PanicStateConsumer
 */
class PanicStateConsumer extends ServiceConsumer
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
        if ($this->getData() == $device->panic_state) {
            $device->update([
                'panic_state' => intval( ! $this->getData()),
            ]);

            // if ($this->getData() == 0) {
            //     event(new PanicStateTriggered($device, $this->getData()));
            // }
        }
    }
}
