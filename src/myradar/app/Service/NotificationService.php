<?php

namespace App\Service;

use Illuminate\Support\Facades\Log;
use Davibennun\LaravelPushNotification\Facades\PushNotification;
use App\Events\UnregisteredTokenFound;

class NotificationService
{
    public static $TYPE_ENGINE  = 20;
    public static $TYPE_FENCE   = 22;
    public static $TYPE_DATE    = 1;
    public static $TYPE_SPEED   = 21;
    public static $TYPE_BILL    = 24;
    public static $TYPE_FUEL    = 6;
    public static $TYPE_GAS     = 7;

    function __construct()
    {
        //
    }

    public function send($data, $tokens)
    {
        $message = $this->getPayload($data);
        $conf = env('APP_ENV') == 'local' ? 'ios-dev' : 'ios';

        if ($tokens->get('ios')->count() > 0) {
            $tokens->get('ios')->reverse()->values()->each(function($t) use ($message) {
                try {
                    $ret = PushNotification::app('ios')
                            ->to(PushNotification::Device($t, array()))
                            ->send($message);

                    $it = $ret->pushManager->getPushCollection()->getIterator();
                    $it->seek(0);
                    $itr = $it->current()->getResponses()->getIterator();
                    $itr->seek(0);
                    $response = $itr->current();

                    if ( ! ($response['id'] == NULL && $response['token'] == 0)) {
                        event(new UnregisteredTokenFound($t, 1));
                    }
                } catch (Exception $e) {}
            });
        }

        if ($tokens->get('android')->count() > 0) {
            $android_tokens = PushNotification::DeviceCollection(
                $tokens->get('android')->map(function($t) {
                    return PushNotification::Device($t, array());
                })->all()
            );

            PushNotification::app('android')
                    ->to($android_tokens)
                    ->send($message);
        }
    }

    private function getPayload($data) {
        return PushNotification::Message($data->get('body'), [
            'title' => $data->get('title', ''),
            'custom' => [
                'data' => [
                    'type' => intval($data->get('type')),
                    'status' => intval($data->get('status', -1)),
                    'car_id' => $data->get('car_id', ''),
                    'sound' => 1,
                    'vibrate' => 0,
                ]
            ]
        ]);
    }

}
