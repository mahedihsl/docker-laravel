<?php

namespace App\Generator;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Consumer\LatLngConsumer;
use App\Consumer\FuelConsumer;
use App\Consumer\SpeedConsumer;
use App\Consumer\IbsConsumer;
use App\Consumer\GasConsumer;
use App\Consumer\EngineStatusConsumer;
use App\Consumer\GeoFenceConsumer;
use App\Consumer\DistanceConsumer;
use App\Consumer\VelocityConsumer;
use App\Consumer\NewServiceConsumer;
use App\Consumer\PanicStateConsumer;

use App\Entities\Device;
use App\Service\PackageService;

/**
 * @class ServiceConsumerGenerator
 */
class ServiceConsumerGenerator
{
    const KEY_LATLNG    = 'lt';
    const KEY_ENGINE    = 'es';
    const KEY_FUEL      = 'fl';
    const KEY_GAS       = 'gs';
    const KEY_FENCE     = 'gv';
    const KEY_SPEED     = 'sp';
    const KEY_VELOCITY  = 'vl';
    const KEY_NS        = 'ns';
    const KEY_IBS       = 'ibs';
    const KEY_PANIC     = 'panic';

    private $mapper = [
        self::KEY_ENGINE => [
            'service' => PackageService::ENGINE,
            'consumer' => EngineStatusConsumer::class,
        ],
        self::KEY_LATLNG => [
            'service' => PackageService::LATLNG,
            'consumer' => LatLngConsumer::class,
        ],
        self::KEY_FUEL => [
            'service' => PackageService::FUEL,
            'consumer' => FuelConsumer::class,
        ],
        self::KEY_GAS => [
            'service' => PackageService::GAS,
            'consumer' => GasConsumer::class,
        ],
        self::KEY_SPEED => [
            'service' => PackageService::SPEED,
            'consumer' => SpeedConsumer::class,
        ],
        self::KEY_VELOCITY => [
            'service' => PackageService::SPEED,
            'consumer' => VelocityConsumer::class,
        ],
        self::KEY_NS => [
            'service' => PackageService::NS,
            'consumer' => NewServiceConsumer::class,
        ],
        self::KEY_PANIC => [
            'service' => PackageService::PANIC,
            'consumer' => PanicStateConsumer::class,
        ],
		self::KEY_IBS => [
            'service' => PackageService::IBS,
            'consumer' => IbsConsumer::class,
        ],
    ];

    /**
     * @var Device
     */
    private $device;

    private $data;

    private $positions;

    function __construct($device, Collection $data)
    {
        $this->device = $device;
        $this->data = $data;
        $this->positions = collect();
    }

    public function apply()
    {
        $count = collect();
		$runtime = collect();

        foreach ($this->mapper as $key => $obj) {
            if ($this->data->has($key) && strlen($this->data->get($key))) {
                try {
					// $start = round(microtime(true) * 1000);
                    $temp = $this->data->get($key);
                    $consumer = null;

                    if ($key != self::KEY_SPEED) {
                        $class = $obj['consumer'];
                        $consumer = new $class($temp);
                        if ($key == self::KEY_VELOCITY) {
                            $consumer->setPositions($this->positions);
                        }
                        if ($consumer instanceof LatLngConsumer) {
                            $consumer->setSpeed($this->data->get('vl', ''));
                        }
                        $ret = $consumer->consume($this->device);
                        if ($key == self::KEY_LATLNG) {
                            $this->positions = $ret;
                        }
                    } else {
                        $consumer = $this->speedPatch($temp);
                        if ($consumer instanceof VelocityConsumer) {
                            $consumer->setPositions($this->positions);
                        }
                        $consumer->consume($this->device);
                    }

                    $count->put($key, $consumer->count());

                } catch (\Exception $e) {
                    Log::info('exception in service consumer', [
                        'message' => $e->getMessage(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'key' => $key,
						'data' => $this->data->toArray(),
                    ]);
                    continue;
                }
            }
        }

        return $count;
    }

    private function speedPatch($data)
    {
        if (strpos($data, ',') === FALSE) {
            return new VelocityConsumer($data);
        }

        return new SpeedConsumer($data);
    }
}
