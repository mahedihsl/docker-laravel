<?php

namespace App\Service;

use App\Service\Microservice\PushMicroservice;
use Illuminate\Support\Collection;

class OneSignalService
{
    private $gateway;

    function __construct()
    {
        $this->gateway = new PushMicroservice();
    }

    // public function validate()
    // {
    //     if ( ! sizeof($this->playerIds)) return false;

    //     return true;
    // }

    function send($user_id, $data) {
		if (env('APP_ENV') == 'test') {
			return null;
        }
        
        $this->gateway->send($user_id, $data);

        // $this->playerIds = $playerIds;
        // $this->data = $data;
        // if ($this->validate()) {
        //     return $this->execute();
        // }

		// return null;
    }

    // private function execute()
    // {
    //     $fields = array(
	// 		'app_id' => config('signal.app_id'),
	// 		'include_player_ids' => $this->playerIds,
    //         'headings' => ['en' => $this->data->get('title', '')],
	// 		'contents' => ['en' => $this->data->get('body')],
    //         'data' => [
    //             'type'      => intval($this->data->get('type')),
    //             'status'    => intval($this->data->get('status', -1)),
    //             'car_id'    => $this->data->get('car_id', ''),
    //             'sound'     => $this->data->get('sound', 1),
    //             'vibrate'   => $this->data->get('vibrate', 0),
    //         ],
    //         'android_channel_id' => '0fee4278-8c31-41fb-820a-9e5ac82548e6',
	// 	);

	// 	$fields = json_encode($fields);
    // 	// print("\nJSON sent:\n");
    // 	// print($fields);

	// 	$ch = curl_init();
	// 	curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
	// 	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    //         'Content-Type: application/json; charset=utf-8',
    //         'Authorization: Basic ' . config('signal.rest_api_key')));
	// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	// 	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	// 	curl_setopt($ch, CURLOPT_POST, TRUE);
	// 	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	// 	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

	// 	$response = curl_exec($ch);
	// 	curl_close($ch);

	// 	return $response;
    // }
}
