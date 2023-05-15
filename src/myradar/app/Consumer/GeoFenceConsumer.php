<?php

namespace App\Consumer;

use App\Entities\Fence;
use App\Entities\Device;
use App\Events\FenceCrossEvent;

/**
 * @class GeoFenceConsumer
 */
class GeoFenceConsumer extends ServiceConsumer
{

    function __construct($data)
    {
        parent::__construct($data);
    }

    /**
     * data format: id,flag|id,flag|id,flag
     */
    protected function transform($data)
    {
        $all = collect();
        $chunks = collect(explode('|', $data));

        foreach ($chunks as $key => $chunk) {
            $arr = explode(',', $chunk);
            $all->put($arr[0], boolval($arr[1]));
        }

        return $all;
    }

    public function consume(Device $device)
    {
        foreach ($this->getData() as $key => $value) {
            if ( ! is_null($fence = Fence::find($key))) {
                if ( ! ($value && $device->meta->get('fence_id') === $key)) {
                    event(new FenceCrossEvent($device, $fence, $value));
                }
            }
        }
    }
}
