<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Service\Refuel\DetectGasRefuel;
use App\Service\Refuel\DetectFuelRefuel;

class MonitorRefuelEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const TYPE_GAS = 1;
    const TYPE_FUEL = 2;

    public $tries = 3;
    public $timeout = 20;

    private $type;

    private $deviceId;
    private $recordId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($deviceId, $recordId, $type)
    {
        $this->deviceId = $deviceId;
        $this->recordId = $recordId;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $service = $this->type == self::TYPE_GAS
                    ? new DetectGasRefuel()
                    : new DetectFuelRefuel();

        $samples = $service->samples($this->deviceId, $this->recordId);
        $flag = 0;
        if ( ! is_null($samples) && $service->check($samples)) {
            $flag = 1;
            $service->message($this->deviceId);
        }

    }

}
