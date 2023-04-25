<?php

namespace App\Http\Controllers\Api\GeoFence;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\DeviceRepository;
use App\Criteria\CommercialIdCriteria;
use App\Entities\Fence;

class DeviceController extends Controller
{
    private $repository;

    public function __construct(DeviceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getFences(Request $request)
    {
        $criteria = new CommercialIdCriteria($request->input('com_id'));
        $this->repository->pushCriteria($criteria);

        $device = $this->repository->first();

        if ( ! is_null($device)) {
            $fences = $device->user->fences->reduce(function($carry, $item) {
                $val = array($item->id, $item->lat, $item->lng, $item->radius);
                if (strlen($carry)) {
                    $carry .= "\n";
                }
                return $carry . implode(',', $val);
            }, '');

            return $fences;
        }

        return '0';
    }

    public function onUpdate(Request $request)
    {
        $criteria = new CommercialIdCriteria($request->input('com_id'));
        $this->repository->pushCriteria($criteria);

        $device = $this->repository->first();
        $fence = Fence::find($request->input('id'));
        $flag = boolval($request->input('flag'));

        if ( ! is_null($device) && ! is_null($fence)) {
            // TODO: notify user about geofence update

            return '1';
        }

        return '0';
    }
}
