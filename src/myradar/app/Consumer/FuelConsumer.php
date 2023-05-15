<?php

namespace App\Consumer;

use App\Entities\Device;
use Illuminate\Support\Facades\Log;
use App\Service\Microservice\FuelMicroservice;

use App\Contract\Repositories\FuelHistoryRepository;
use App\Service\Microservice\ServiceException;

/**
 * @class FuelConsumer
 */
class FuelConsumer extends ServiceConsumer
{
    const SAMPLE_COUNT = 30;

    private $fuelService;

    /**
     * @var FuelHistoryRepository
     */
    private $repository;

    function __construct($data)
    {
        parent::__construct($data);

        $this->fuelService = new FuelMicroservice();
        $this->repository = resolve(FuelHistoryRepository::class);
    }

    protected function transform($data)
    {
        return intval($data);
    }

    public function consume(Device $device)
    {
        try {
            $this->fuelService->consume($device->com_id, $this->getData());
        } catch (\Exception $e) {
            Log::info('Fuel microservice error:: ' . $e->getMessage());
        }
        
        // $status = $device->engine_status;
        // if ($status) {
        //     $record = $this->repository->save($device, $this->getData());
        //     if ($this->getData() > 0) {
        //         $meter = $device->meter;
        //         $count = config('car.refuelByFiltering.fuel.minBatchSize');
        //         while($meter->get('fuel')->count() >= $count){
        //           $meter->get('fuel')->shift();
        //         }
        //         while ($meter->get('newFuel')->count() >= $count) {
        //             $meter->get('newFuel')->shift();
        //         }
        //         $meter->get('fuel')->push($this->getData());
        //         $meter->get('newFuel')->push($this->getData());
        //         $device->meter = $meter;
        //         $device->save();

        //         event(new FuelReceived($device, $record));
        //     }
        // }
    }
}
