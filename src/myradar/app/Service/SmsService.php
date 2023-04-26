<?php

namespace App\Service;

use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\ClientException;
use App\Entities\SmsLog;
use App\Service\Microservice\SmsMicroservice;

/**
 * Service for sending Text SMS
 */
class SmsService
{
    private $debug;
    private $gateway;

    function __construct($debug = false)
    {
        $this->debug = $debug;
        $this->gateway = new SmsMicroservice();
    }

    public function send($phone, $content, $type = 'unknown')
    {
		if (env('APP_ENV') == 'test') {
			return FALSE;
        }
        
        return $this->gateway->send($phone, $content, $type);

        // $options = [
        //     'debug' => false,
        //     'form_params' => [
        //         'Username'  => config('sms.username'),
        //         'Password'  => config('sms.password'),
        //         'From'      => config('sms.sender'),
        //         'To'        => $phone,
        //         'Message'   => $content,
        //     ]
        // ];

        // SmsLog::create([
        //     'to' => $phone,
        //     'body' => $content,
        //     'type' => $type,
        // ]);

        // try {
        //     $client = new \GuzzleHttp\Client(['base_uri' => config('sms.api')]);
        //     $result = $client->post('SendTextMessage', $options);
        // } catch (ClientException $e) {
        //     if ($this->debug) {
        //         return $e->getResponse()->getBody()->getContents();
        //     }
        //     return FALSE;
        // }

        // return $result->getBody();
    }
}
