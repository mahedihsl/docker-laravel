<?php

namespace App\Http\Controllers\Api\Device;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

use App\Entities\Device;
use Vinkla\Pusher\Facades\Pusher;

use App\Service\PusherService;
use App\Criteria\CommercialIdCriteria;
use App\Contract\Repositories\DeviceRepository;
use App\Entities\ServiceString;
use App\Service\Microservice\ET200Microservice;

use App\Events\EngineStatusChanged;
use App\Events\LockWhenEngineOnEvent;
use App\Events\LockWhenEngineOffEvent;
use App\Events\UnlockWhenEngineOnEvent;
use App\Events\UnlockWhenEngineOffEvent;
use Carbon\Carbon;
use Exception;


class EngineController extends Controller
{
    /**
     * @var DeviceRepository
     */
    private $repository;

    public function __construct(DeviceRepository $repository)
    {
        $this->repository = $repository;
        $this->concox = new ET200Microservice();
    }

    public function status(Request $request, $id)
    {
        $device = $this->repository->find($id);

        if (!is_null($device)) {
            return response()->json([
                'lock' => $device->lock_status,
                'engine' => $device->engine_status,
            ]);
        }

        return response()->error('Device not Found');
    }

    public function transitionStatus(Request $request)
    {
        try {
            $device = $this->repository->find($request->get('device_id'));
            if (!is_null($device)) {
                $info = $this->concox->status($device->com_id);
                return response()->json([
                    "transition" => intval($info['transition']),
                    "engine" => intval($info['synthetic_engine']),
                    "lock" => intval($info['controlled_state']),
                ]);
            }
        } catch (\Exception $th) {
        }
        return response()->error('Device not connected');
    }

    public function updateLock(Request $request)
    {
        $device = Device::where('com_id', intval($request->get('com_id')))->first();
        if (!is_null($device)) {
            $device->update(['lock_status' => intval($request->get('lock'))]);
            return response()->json();
        }

        return response()->error();
    }

    public function toggle(Request $request)
    {
        $user = $request->user('api');
        if (is_null($user)) {
            $user = $request->user();
        }
        if ($user->demo) {
            return response()->error('No Real Car !');
        }

        $target_lock = intval($request->get('lock_status'));
        $device = $this->repository->find($request->get('device_id'));

        if (!$device->car->status) {
            return response()->error('Car is not active');
        }

        if (!is_null($device)) {
            if (!$user->isSharedCar($device->car_id)) {
                if ($device->engine_status === 1) {
                    if ($target_lock === 1) {
                        event(new LockWhenEngineOnEvent($device));
                    } else {
                        event(new UnlockWhenEngineOnEvent($device));
                    }
                } else {
                    if ($target_lock === 1) {
                        event(new LockWhenEngineOffEvent($device));
                    } else {
                        event(new UnlockWhenEngineOffEvent($device));
                    }
                }

                return response()->json(['lock_status' => $device->lock_status,]);
            }
        }
        return response()->error();
    }

    public function updateControlState(Request $request)
    {
        $target_lock = intval($request->get('lock_status'));
        $device = $this->repository->find($request->get('device_id'));

        if (is_null($device)) {
            return response()->json(['message' => 'Device not found'], 400);
        }

        if (!$device->car->status) {
            return response()->json(['message' => 'Car is not active'], 400);
        }

        if ($device->engine_status === 1 && $target_lock === 1) {
            return response()->json(['message' => 'You can not warm engine'], 400);
        }

        try {
            if ($target_lock === 1) {
                $this->concox->lock($device->com_id);
            } else {
                $this->concox->unlock($device->com_id);
            }
        } catch (\Exception $th) {
            return response()->json(['message' => 'Car is offline now'], 400);
        }

        $device->update(['lock_status' => $target_lock]);

        return response()->json();
    }

    public function update(Request $request)
    {
        $criteria = new CommercialIdCriteria($request->get('com_id'));
        $device = $this->repository->skipPresenter()->pushCriteria($criteria)->first();

        try {
            $com_id = intval($request->get('com_id'));
            if (in_array($com_id, [19990, 32289, 18638])) {
                $data = $request->all();
                $data['type'] = 'engine_update';
                ServiceString::create([
                    'com_id' => $com_id,
                    'data' => $data,
                ]);
                return '0';
            }
        } catch (\Exception $e) {
            //throw $th;
        }

        if (!is_null($device)) {
            $status = intval($request->get('status'));
            event(new EngineStatusChanged($device, $status));
            if ($status == 0) {
                $device->update([
                    'engine_status' => $status,
                    'off_by' => 'device',
                ]);
                $notify = new PusherService();
                $notify->onEngineOff($device);
                return '2';
            } else {
                $device->update([
                    'engine_status' => $status,
                    'last_start' => Carbon::now(),
                ]);
                return '1';
            }
        }

        return '0';
    }

    public function consume(Request $request)
    {
        $com_id = intval($request->get('com_id'));
        $device = Device::raw(function ($collection) use ($com_id) {
            return $collection->findOne([
                'com_id' => ['$eq' => $com_id]
            ]);
        });

        $status = intval($request->get('status'));
        event(new EngineStatusChanged($device, $status));
        return response()->json();
    }

    public function test(Request $request)
    {
        $criteria = new CommercialIdCriteria($request->get('com_id'));
        $device = $this->repository->skipPresenter()->pushCriteria($criteria)->first();
        $user = $device->user;

        $data = [
            'engine_status' => $device->engine_status,
            'lock_status' => $device->lock_status,
        ];
        Pusher::trigger('map-channel-' . $user->id, 'engine-off-event', [
            'message' => $data
        ]);

        return $res;
    }
}
