<?php

namespace App\Http\Controllers\Api\Device;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Criteria\CommercialIdCriteria;
use App\Generator\ServiceConsumerGenerator;
use App\Contract\Repositories\DeviceRepository;
use App\Events\ServiceStringReceived;
use App\Entities\Device;
use Carbon\Carbon;

class ServiceController extends Controller
{
    /**
     * @var DeviceRepository
     */
    private $repository;

    public function __construct(DeviceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function consume(Request $request)
    {
        $criteria = new CommercialIdCriteria($request->get('ss'));
        $this->repository->pushCriteria($criteria);

        if ( ! is_null($device = $this->repository->first())) {
            $generator = new ServiceConsumerGenerator($device, collect($request->all()));
            $count = $generator->apply();

            event(new ServiceStringReceived($device, $count));

            return strval($device->lock_status);
        }

        return '-1';
    }

    public function removeData(Request $request, $type)
    {
        $date = Carbon::createFromDate(2019, 4, 5);
        $date->hour = 0;
        $date->minute = 0;
        $date->second = 0;

        $ret = collect();
        foreach (Device::all() as $device) {
            if ($type == 1) {
                $n = $device->positions()->where('when', '<', $date)->forceDelete();
            } else if ($type == 2) {
                $n = $device->gas_histories()->where('when', '<', $date)->forceDelete();
            } else if ($type == 3) {
                $n = $device->fuel_histories()->where('when', '<', $date)->delete();
            } else $n = 0;

            if ($n) {
                $ret->push($n);
            }

        }

        return [
            'date' => $date->toDayDateTimeString(),
            'total' => $ret->sum(),
            'data' => $ret,

        ];
    }
}
