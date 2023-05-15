<?php

namespace App\Consumer;

use App\Entities\Device;

/**
 * Interface ConsumerInterface
 * @package namespace App\Consumer;
 */
interface ConsumerInterface
{
    /**
     * Handles all the business logic
     * corresponding to this service data
     */
    public function consume(Device $device);
}
