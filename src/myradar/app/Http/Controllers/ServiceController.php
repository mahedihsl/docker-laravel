<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Events\ServiceStringReceived;
use App\Events\ExternalDeviceDataReceived;
use App\Criteria\CommercialIdCriteria;
use App\Generator\ServiceConsumerGenerator;
use App\Contract\Repositories\DeviceRepository;
use App\Entities\ServiceString;
use App\Entities\Device;
use App\Service\Log\Log as LogLog;
use App\Service\Microservice\RMSReceiverMicroservice;
use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;

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
        // $start = round(microtime(true) * 1000);
        $com_id = intval($request->get('ss'));

        try {
            $serviceString = ServiceString::create([
                'com_id' => intval($com_id),
                'data' => $request->all(),
            ]);
            $rmsKeys = collect([
                'DM1', 'DM2',
                'DM3', 'DM4',
                'DM5', 'DM6',
                'DM7', 'DM8',
                'AM1', 'AM2',
                'AM3', 'AM4',
                'AM5', 'AM6',
            ]);
            $intersect = collect($request->all())->keys()->intersect($rmsKeys)->values();
            if ($intersect->count() == $rmsKeys->count()) {
                Log::info('rms-string received', $request->all());
                $rmsService = new RMSReceiverMicroservice();
                $res = $rmsService->receive($request->all());

                $reply = $res['reply'];
                $serviceString->update([
                    'data' => array_merge(
                        $request->all(),
                        $res['pieces'],
                        ['response' => $reply]
                    )
                ]);

                // if ($com_id == 28592) return '0,0,_,_,15-17-19-04-22,0';

                return $reply; // DC1,DC2,ADD_CARD,DELETE_CARD,TIME_UPDATE,CLEAR_CARDS,ERASE_LOG
            }
        } catch (\Exception $e) {
            Log::info('rms-string identification error', ['message' => $e->getMessage()]);
            return '0,0,_,_,_,0'; // DC1,DC2
        }


        $device = Device::raw(function ($collection) use ($com_id) {
            return $collection->findOne([
                'com_id' => ['$eq' => $com_id]
            ]);
        });

        if (!is_null($device)) {

            try {
                $generator = new ServiceConsumerGenerator($device, collect($request->all()));
                $count = $generator->apply();
                event(new ServiceStringReceived($device, $count));
            } catch (\Exception $e) {
            }

            // try {
            //     $client_id = '5f63f8599dbb7723d01f7224'; // Jatri App
            //     if ($device->user_id == $client_id) {
            //         // Log::info('Jatri data received');
            //         if ($device->user->isEnabled()) {
            //             $enabled = $device->car ? boolval($device->car->status) : false;
            //             if ($enabled) {
            //                 // Log::info('Jatri data forwarded: ' . $device->com_id);
            //                 event(new ExternalDeviceDataReceived($device, $request->all()));
            //             } else {
            //                 // Log::info('Jatri car disabled: ' . $device->com_id);
            //             }
            //         }
            //     }
            // } catch (\Exception $e) {
            //     Log::info('Jatri data exception', [
            //         'msg' => $e->getMessage(),
            //     ]);
            // }
            // return '0';
            return strval($device->lock_status);
        }

        return '-1';
    }

    // public function external($request)
    // {
    // 	$client = new Client();
    // 	$response = $client->request('POST', 'http://45.64.135.28/api/test/device/receive', [
    // 		'form_params' => [
    // 			'protocol' => 1,
    // 			'data' => $request->all(),
    // 		]
    // 	]);
    //
    // 	return $response->getBody();
    // }
}
