<?php

namespace App\Consumer;

use App\Entities\Device;
use App\Events\EngineStatusChanged;
use Carbon\Carbon;

/**
 * @class EngineStatusConsumer
 */
class EngineStatusConsumer extends ServiceConsumer
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
        $newStatus = $this->getData();
        if ($device->engine_status != $newStatus) {
            $props = ['engine_status' => $newStatus];
            if ( ! $newStatus) {
                $props['off_by'] = 'server';
            } else {
                $props['last_start'] = Carbon::now();
            }
            $device->update($props);

            event(new EngineStatusChanged($device, $newStatus));
        }
    }
}
