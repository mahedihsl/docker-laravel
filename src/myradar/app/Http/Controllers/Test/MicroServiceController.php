<?php

namespace App\Http\Controllers\Test;

use App\Entities\PendingNotice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Microservice\GeofenceMicroservice;
use App\Service\Microservice\ServiceException;
use App\Service\Microservice\SmsMicroservice;
use App\Service\Microservice\SpeedMicroservice;
use App\Service\Microservice\DeviceMicroservice;
use App\Service\Microservice\FuelMicroservice;
use App\Service\Microservice\MsgIdMicroservice;
use App\Service\Microservice\UserMicroservice;
use App\Service\Microservice\MileageMicroservice;

class MicroServiceController extends Controller
{
    public function mileage(Request $request)
    {
        $service = new MileageMicroservice();
        return response()->json($service->recalculate($request->all()));
    }

    public function testFuel(Request $request)
    {
        $service = new FuelMicroservice();
    }

    public function messageId(Request $request)
    {
        try {
            $service = new MsgIdMicroservice();
            return response()->json($service->next());
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function session(Request $request)
    {
        $service = new UserMicroservice();
        $data = $service->getSessionList('5f63f8719dbb7723d01f7396');
        return response()->json($data);
    }

    public function speed(Request $request)
    {
        $car_id = $request->get('car_id');
        $com_id = $request->get('com_id');
        $speed = $request->get('speed');

        $service = new SpeedMicroservice();
        $data = $service->observe($car_id, $com_id, $speed);
        return response()->json($data);
    }

    public function testGeofence(Request $request)
    {
        $car_id = '5f63facb36374b3de61bae06';

        // Outside geofence
        // $lat = 23.8379784;
        // $lng = 91.3696889;

        // Inside Geofence
        $lat = 23.8379784;
        $lng = 90.3696889;
        
        $service = new GeofenceMicroservice();
        return response()->json($service->test($car_id));
    }

    public function testPush(Request $request)
    {
        $client = new \GuzzleHttp\Client(['base_uri' => 'http://myradar-push:6001/']);
        $res = $client->post('send', [
            'form_params' => [
                'user_id' => '5b557d33fbe09d45b3017252',
                "payload" => [
                    "title" => "Test Push Microservice",
                    "body" => "Ignore this notification. This is for development purpose.",
                    "type" => 0
                ]
            ]
        ]);
        return $res->getBody();
    }

    public function testSms(Request $request)
    {
        $service = new SmsMicroservice();
        $res = $service->send('01627892968', 'Sms Microservice working', 'test', 'en');
        // $client = new \GuzzleHttp\Client(['base_uri' => 'http://myradar-sms:6002/']);
        // $res = $client->post('send', [
        //     'form_params' => [
        //         'phone' => '01627892968',
        //         'content' => 'Sms Microservice working',
        //         'type' => 'test'
        //     ]
        // ]);
        return $res;
    }

    public function testUser(Request $request)
    {
        try {
            $user_id = '5dc3d63b91c404000c19a62a';
            $service = new UserMicroservice();
            $response = $service->statusHistory($user_id);
            return $response;
        } catch (ServiceException $e) {
            return $e;
        }
    }
    
    public function testEngineNotification(Request $request)
    {
        try {
            $service = new DeviceMicroservice();
            $response = $service->consumeEngineStatus(58813, 1);
            return response()->json($response);
        } catch (ServiceException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function deviceConfig(Request $request)
    {
        try {
            $device_id = '5f63fbc832ebd87dc662fb56';
            $service = new DeviceMicroservice();
            return response()->json($service->deviceConfig($device_id));
        } catch (\Exception $error) {
            return response()->json(['error' => $error->getMessage()]);
        }
    }

    public function trimDatabase(Request $request)
    {
        try {
            // $service = new SupervisorMicroservice();
            // return response()->json($service->trimData());
        } catch (\Exception $error) {
            return response()->json(['error' => $error->getMessage()]);
        }
    }
}
