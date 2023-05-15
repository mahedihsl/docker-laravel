<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entities\Car;
use App\Entities\User;
use App\Service\Microservice\PushMicroservice;

class PushNotificationController extends Controller
{
    public function test(Request $request)
    {
        $res = collect();
        $reg_no = $request->reg_no;
        if ($reg_no) {
            $res->push('Starting diagnosis for: ' . $reg_no);
            $car = Car::where('reg_no', $reg_no)->first();

            if (is_null($car)) {
                $res->push('Car not found');
            } else if (is_null($car->user)) {
                $res->push('Car is not binded to any user');
            } else {
                $res->push('Car found in DB');
                $res->push('Sending Push Notification to: ' . $car->user->name);

                $title = $request->get('title');
                $body = $request->get('body');
                $type = intval($request->get('type', '0'));
                $data = [
                    'title' => $title,
                    'body' => $body,
                    'type' => $type,
                    'large_icon' => $request->get('large_icon', ''),
                    'banner_url' => $request->get('banner_url', ''),
                ];

                $service = new PushMicroservice();
                $ret = $service->send($car->user_id, $data);

                $socketRecipients = $ret['recipients']['socket'];
                $oneSignalRecipients = $ret['recipients']['onesignal'];

                $res->push('Notification Type: ' . $type);
                $res->push('Notification sent to ' . ($socketRecipients + $oneSignalRecipients) . ' Mobile Devices');
                $res->push('Via WebSocket = ' . $socketRecipients);
                $res->push('Via OneSignal = ' . $oneSignalRecipients);
            }
            $res->push('Diagnosis finished');
        }

        return view('test.push-noti')->with([
            'messages' => $res,
        ]);
    }

    private function trace($event, $listener)
    {
        $arr = collect();
        if (is_null($event->device->user)) {
            $arr->push('Device is not connected with an user');
            return $arr;
        }

        $arr->push('Device is connected with user: ' . $event->device->user->name);

        if (is_null($event->device->car)) {
            $arr->push('Device is not connected with a car');
            return $arr;
        }

        $arr->push('Device is connected with car: ' . $event->device->car->reg_no);

        $deliverable = $listener->deliverable($event->device->car, $event->limit, $event->flag);
        if (!$deliverable) {
            $arr->push('Notification is not deliverable');
            return $arr;
        }

        $arr->push('Deliverable check is passed');

        $data = $listener->payload($event);
        $arr->push(json_encode($data));

        $private = $event->device->user->customer_type == User::$CUSTOMER_PRIVATE;
        $arr->push('Customer type is: ' . ($private ? 'private' : 'enterprise'));

        if ($private && !($fl = $listener->privateValidate($event->device->user))) {
            $arr->push('Private customer settings problem, speed notification = ' . $fl);
            return $arr;
        }

        $arr->push('Private customer settings are ok');

        $delivered = $listener->execute($event->device->user, $event->device, $data);

        $arr->push('Notification delivery response: ' . $delivered);

        return $arr;
    }
}
