<?php

namespace App\Http\Controllers\PushNotification;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\Device;
use App\Entities\UserLogin;
use App\Entities\User;
use Edujugon\PushNotification\PushNotification;
use DB;
use Carbon\Carbon;
use App\Helpers\AppHelper;

class PushNotificationController extends Controller
{

//if fcm returns unregisted device token then we remove the device_token from user_logins

    //Push type
    // 1 =>Date notification
    //2 = Car on /off
    //3 = GeoFence
    //4 = Speed
    public function __construct()
    {
        $this->AppHelper = new AppHelper();
        $this->fcm_server_key = 'AAAAmPHor_E:APA91bE7T-BAwkq1IYbyFpoz06E_fakZPuthgxim-nJLbZqlFF7TXSmr3LNEVLQSCCpk7J31MkNG4YonJWqH36Zu_IUCvyIVqUglXgp-U2-TidMFkJqjFFaw-WaUztsLwoc8y2lHljyO';
    }

    public function androidPush($message, $title, array $device_tokens, $vibrate=null, $sound=null, $type=null)
    {
        $android_push = new PushNotification('fcm');
        $android_push->setService('fcm')
        ->setMessage([
            'notification' => [
                     'title'=>$title,
                     'body'=>$message,
                     'sound' => $sound,
                     'vibrate'=>$vibrate,
                      'type'=>$type
                     ],
            'data' => [
                     'title' => $title,
                     'body' => $message,
                     'sound' => $sound,
                     'vibrate'=>$vibrate,
                     'type'=>$type
                    ]
                  ])
                    ->setApiKey($this->fcm_server_key)
                    ->setDevicesToken($device_tokens)
                    ->send();

        // $response = $android_push->getFeedBack();
        // $unregistered = $android_push->getUnregisteredDeviceTokens();

        // DB::table('push_logs')->insert(['push_type'=>$type,
        //                 ///'user_id'=>$user_id,
        //                 //'device_token'=>$device_token,
        //                 'response'=>$response,
        //                  'unregistered_device_token'=>$unregistered,
        //                 'time'=>Carbon::now(),
        //                 'device_type'=>0
        //               ]);


    }

    public function iosPush($message, $title, array $device_tokens, $vibrate=null, $sound=null, $type=null)
    {
        $ios_push =new PushNotification('apn');
        $failed = $ios_push->setService('apn')
                  ->setMessage([
                 'aps' => [
                     'alert' => [
                         'title' => $title,
                         'body' => $message,
                        //  'type'=>$type
                     ],
                    'sound' => 'default'

                 ],
                 'extraPayLoad' => [
                    'type'=>$type
                 ]
             ])
         ->setDevicesToken($device_tokens)
         ->send()
         ->getUnregisteredDeviceTokens();

        // $response = $ios_push->getFeedBack();
        // $unregistered = $ios_push->getUnregisteredDeviceTokens();
        //
        // DB::table('push_logs')->insert(['push_type'=>$type,
        //      //'user_id'=>$user_id,
        //      //'device_token'=>$device_token,
        //      'response'=>$response,
        //       'unregistered_device_token'=>!empty($response['tokenFailList'])?$response['tokenFailList']:"",
        //      'time'=>Carbon::now(),
        //      'device_type'=>1
        //    ]);

    }

    public function iosPushSingle($message, $title, $device_token, $user_id=null, $vibrate=null, $sound=null, $type=null, $device_type=1)
    {
        $ios_push = new PushNotification('apn');
        $ios_push->setService('apn')
                ->setMessage([
               'aps' => [
                   'alert' => [
                       'title' => $title,
                       'body' => $message
                   ],

               ],

           ])
       ->setDevicesToken($device_token)
       ->send()
       ->getFeedBack();

        $response = $ios_push->getFeedBack();
        $unregistered = $ios_push->getUnregisteredDeviceTokens();

        //  if(isset($unregistered['unregistered_device_token'][0]))
        //   {
        //     $this->AppHelper->removeUnregisteredDeviceLogin($unregistered['unregistered_device_token'][0]);
        //   }

        DB::table('push_logs')->insert(['push_type'=>$type,
           'user_id'=>$user_id,'device_token'=>$device_token,
           'response'=>$response,
            'unregistered_device_token'=>$unregistered,
           'time'=>Carbon::now(),
           'device_type'=>$device_type
         ]);
    }
    public function androidPushSingle($message, $title, $device_token, $user_id=null, $vibrate=null, $sound=null, $type=null, $device_type=0)
    {
        $android_push = new PushNotification('fcm');
        $android_push->setService('fcm')
        ->setMessage([
            'notification' => [
                    'title'=>$title,
                     'body'=>$message,
                     'sound' => $sound,
                     'vibrate'=>$vibrate,
                      'type'=>$type
                     ],
            'data' => [
                     'title' => $title,
                     'body' => $message,
                     'sound' => $sound,
                     'vibrate'=>$vibrate,
                     'type'=>$type
                    ]
                  ])
                    ->setApiKey($this->fcm_server_key)
                    ->setDevicesToken($device_token)
                    ->send()
                    ->getFeedBack();

        $response = $android_push->getFeedBack();
        $unregistered = $android_push->getUnregisteredDeviceTokens();

        //  if(isset($unregistered['unregistered_device_token'][0]))
        //   {
        //     $this->AppHelper->removeUnregisteredDeviceLogin($unregistered['unregistered_device_token'][0]);
        //   }

        DB::table('push_logs')->insert(['push_type'=>$type,
                                  'user_id'=>$user_id,
                                   'device_token'=>$device_token,
                                    'response'=>$response,
                                   'unregistered_device_token'=>$unregistered,
                                   'time'=>Carbon::now(),
                                   'device_type'=>$device_type
                                 ]);
    }
}
