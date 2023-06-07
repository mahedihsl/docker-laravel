<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\SmsService;
use App\Service\OneSignalService;
use App\Service\Sms\DailySummerySms;
use App\Jobs\SmsSendingJob;
use App\Jobs\DailySummerySmsJob;
use App\Jobs\PushNotificationJob;
use App\Entities\Car;
use App\Entities\User;
use App\Service\Microservice\PushMicroservice;
use App\Service\Microservice\ServiceException;
use App\Service\Microservice\UserMicroservice;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function testMileagePush(Request $request)
    {
        try {
            $service = new UserMicroservice();
            $data = $service->testMileagePush($request->get('user_id'));
            return response()->json($data);
        } catch (ServiceException $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function sms(Request $request)
    {
        $phone = $request->get('phone');
        $content = 'Testing SMS from myRADAR';

        // return response()->json([
        //     'phone' => $phone,
        //     'content' => $content,
        // ]);
        try {
            $gateway = new SmsService();
            $res = $gateway->send($phone, $content);
            // $gateway = new UserMicroservice();
            // $res = $gateway->test();

            return response()->json();            
        } catch (\Exception $e) {
            return response()->error($e->getMessage());
        }

        // $job = new SmsService(true);
        // $res = $job->send($phone, $content);

        // return response()->json([
        //     'data' => $res,
        // ]);
    }

    public function noti(Request $request)
    {
        $data = collect([
            'title' => 'MyRadar Test',
            'body' => 'Testing Push Notification from myRADAR, Ignore this notification',
        ]);

        $gateway = new PushMicroservice();
        $reply = $gateway->send($request->get('user_id'), $data);

        return response()->json([ 'data' => $reply ]);
    }

    // public function onesignal(Request $request)
    // {
    //     $data = collect([
    //         'title' => 'Test Notification',
    //         // 'body' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum",
    //         'body' => "একটা কৃষক ক্ষেতে ফসল ফলাইতে পারলে নিজেকে সার্থক মনে করে । আবার একতা পাইলট বিমান নিয়ে আকাশে উড়তে পারলে নিজেকে সার্থক মনে করে । এখন কৃষক যদি পাইলটকে বলে \"তোমার তো মিয়া জীবনটাই বৃথা , জীবনে জমিনে ফসল ফলাইয়া দেখলা না \"আর পাইলট যদি কৃষককে বলে \"তোমার ও তো জীবন বৃথা, কোনদিন আকাশে উড়লা না\"",
    //         'type' => 0,
    //     ]);

    //     // $ret = json_decode($ret, true);
    //     return $ret;
    // }

    public function smsPack1(Request $request)
    {
        // $car = Car::find('5c9f24145502eb2f9f601de1');
        // $date = Carbon::today();
        // $service = new DailySummerySms($car, $date);
        // dispatch(new SmsSendingJob($car->user->phone, $service->content()));
        // dispatch(new DailySummerySmsJob('5c9f24145502eb2f9f601de1'));
        return 'ok';
    }

    public function fcmNoti(Request $request)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';

        $fields = array (
            'registration_ids' => [
'dD6BvK7U4Ek:APA91bHlOs1lgvw-mgNeQxsifgJ7Zyahr0VOeKrKpQJimG5lbnxid4-7T2Q9IM7pyzotxQqsaKvtYKgFAMlhduQVFx0Jdc__aIClxpaNuTefWPBz-9qV_1Gaw3WjJyat3kft-4DTmi3p'
            ],
            'data' => [
                'title' => 'FCM Testing',
                'body' => "Sample Notification Body",
            ],
	//"message_id" => "dr2:m-1366082849205",
	//'notification' => [
	//		"title" => "ReadyAndroid",
	//		   "description" => "I am Android",
	//	]
        );
        $fields = json_encode ($fields);

        $headers = array (
            'Authorization: key=' . "AAAAvz83S4M:APA91bGEmNX6x1xPiTUwD256B1L6EraftTi0n748iPI7zd1INrPXNwCf8VDZdr2ECMYPF_TffHr5czsKznlSUw3hFzhoewb4HAkjZm-TbtDwsviUQ7ikgjXTmT9b2VTKGyu-v8AaX5ds",
            'Content-Type: application/json'
        );

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

        $result = curl_exec ( $ch );
        curl_close ( $ch );

        return $result;
    }
}
