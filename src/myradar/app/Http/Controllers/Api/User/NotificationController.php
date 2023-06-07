<?php

namespace App\Http\Controllers\Api\User;

use App\Entities\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\PushNotificationJob;
use App\Service\Microservice\PushMicroservice;
use App\Service\OneSignalService;
use Davibennun\LaravelPushNotification\Facades\PushNotification;

class NotificationController extends Controller
{
    public function bind(Request $request)
    {
        $apiToken = $request->get('api_token');
        $user = User::where('api_token', $apiToken)->first();

        if (is_null($user)) {
            return response()->json('Token Received');
        }

        $new_token = $request->get('new');
        $old_token = $request->get('old', '');
        $type = intval($request->get('type'));

        $dev = $type ? 'iOS' : 'Android';
        $log = 'Bind token API from ' . $dev . ' device.';

        if (strlen($old_token)) {
            $user->user_logins()
                ->where('device_type', $type)
                ->where('device_token', $old_token)
                ->delete();
            $log .= 'Removing old token.';
        }

        $exists = $user->user_logins()
                    ->where('device_type', $type)
                    ->where('device_token', $new_token)
                    ->exists();

        if (strlen($new_token) && ! $exists) {
            $user->user_logins()
                ->create([
                    'device_type' => $type,
                    'device_token' => $new_token,
                ]);
            $log .= 'Adding new token.';
        }

        $log .= json_encode($request->all());

        return response()->json('Token Received');
    }

    public function checkSubscription(Request $request)
    {
      $user = $this->getWebUser();
      $new_token = $request->get('new');
      $type = intval($request->get('type'));
      $exists = $user->user_logins()
                  ->where('device_type', $type)
                  ->where('device_token', $new_token)
                  ->where('user_id', $user->id)
                  ->exists();
      return response()->json($exists);;
    }

    public function test(Request $request, $id)
    {
        $data = collect([
            'title' => 'Test Notification',
            'body' => 'Checking your notification service',
            'type' => 0,
        ]);

        $service = new PushMicroservice();
        $service->send($id, $data);

        return response()->json();
    }
}
