<?php

namespace App\Consumer;

use App\Entities\Device;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redis;
use App\Events\SpeedLimitCrossEvent;
use App\Service\Microservice\SpeedMicroservice;

/**
 * @class VelocityConsumer
 */
class VelocityConsumer extends ServiceConsumer
{
    /**
     * @var Collection
     */
    private $positions;

    function __construct($data)
    {
        parent::__construct($data);
    }

    protected function transform($data)
    {
        return floatval($data);
    }

    public function consume(Device $device)
    {
        $speed = $this->getData();

        $this->positions->each(function($pos) use ($speed, $device) {
            $pos->update(['speed' => $speed]);
            // if ($device->version) {
            //     $versionNumber = intval(str_replace('.', '', $device->version));
            //     if ($versionNumber >= 484) {
            //         $this->storeInCache($device, $speed);
            //     }
            // }
        });

        // $this->checkSpeedViolation($device);
        $service = new SpeedMicroservice();
        $service->observe($device->car_id, $device->com_id, $speed);
    }

    // public function storeInCache($device, $speed)
    // {
    //     $key = 'speed:' . $device->com_id;
    //     Redis::command('LPUSH', [$key, $speed]);
    //     Redis::command('LTRIM', [$key, 0, 2]);
    // }

    /**
     * This method is for v4.8.4 device, because from those devices 
     * the speed limit cross data is not sent correctly under 'sp' key
     */
    public function checkSpeedViolation($device)
    {
        // if (!$device->version) return;
        
        // $versionNumber = intval(str_replace('.', '', $device->version));
        // if ($versionNumber < 484) return;

        $service = new SpeedMicroservice();
        $service->observe($device->car_id, $device->com_id, $this->getData());

        // $key = 'speed:' . $device->com_id;
        // $speedRecords = Redis::command('LRANGE', [$key, 0, -1]);
        // if (sizeof($speedRecords) < 3) return;

        // $avgSpeed = collect($speedRecords)
        //                 ->map(function($item) {
        //                     return intval($item);
        //                 })
        //                 ->avg();
        // $limits = $device->car->speed_limit;
        // $key2 = 'current_speed_voilation:' . $device->com_id;
        // $currentViolation = intval(Redis::command('GET', [$key2]));

        // $hardLimit = $limits['hard']['value'];
        // $softLimit = $limits['soft']['value'];
        
        // if ($avgSpeed > $hardLimit && $currentViolation != $hardLimit) {
        //     Redis::command('SET', [$key2, $hardLimit]);
        //     event(new SpeedLimitCrossEvent($device, $hardLimit, 1));
        //     return;
        // }

        // if ($avgSpeed > $softLimit && $currentViolation != $softLimit) {
        //     Redis::command('SET', [$key2, $softLimit]);
        //     event(new SpeedLimitCrossEvent($device, $softLimit, 1));
        //     return;
        // }

        // if ($avgSpeed < $softLimit) {
        //     Redis::command('SET', [$key2, 0]);
        // }
    }

    public function setPositions($list)
    {
        $this->positions = $list;
    }
}
