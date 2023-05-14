<?php

namespace App\Http\Controllers\Api\Health;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Contract\Repositories\HealthRepository;
use App\Contract\Repositories\DeviceRepository;

use App\Criteria\CommercialIdCriteria;
use App\Events\DeviceHealthReceived;
use App\Entities\Device;

use Illuminate\Support\Facades\Log;

class HealthController extends Controller
{
    /**
     * @var HealthRepository
     */
    private $healthRepo;

    /**
     * @var DeviceRepository
     */
    private $deviceRepo;

    public function __construct(HealthRepository $healths, DeviceRepository $devices)
    {
        $this->healthRepo = $healths;
        $this->deviceRepo = $devices;
    }

    public function save(Request $request)
    {
        $com_id = intval($request->get('com_id'));
        $query = [ 'com_id' => ['$eq' => $com_id] ];
        $device = Device::raw(function($collection) use ($query) {
			return $collection->find($query, []);
		})->first();

        if ( ! is_null($device)) {
            $data = collect($request->all());

            $this->healthRepo->save($device, $data);
            event(new DeviceHealthReceived($device, $data));

            return '1';
        }

        return '0';
    }

}
