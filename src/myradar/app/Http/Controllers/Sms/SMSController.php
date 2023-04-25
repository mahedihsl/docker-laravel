<?php

namespace App\Http\Controllers\Sms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\Device;
use App\Entities\User;
use App\Entities\SmsLog;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Stream\Stream;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7;

class SMSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


  //geofence violation
  //engine on off from mobile app to device
    //--Engine on/off to user mobile
     //-- locked state violation to user

  //send sms to devie to check device is alive or not


  public function __construct(){

    $this->GuzzleClient =  new Client(['base_uri' => 'https://api.mobireach.com.bd/']);
     $this->Sender = 'HyperCAR';
     $this->Username = "hyper";
     $this->Password = "Sms@44222";
  }

  public function sendSMS($phone,$content)
  {

      $options = [
         'debug' => false,
         'form_params' => [
             'Username' => $this->Username,
             'Password' => $this->Password,
             'From'=>$this->Sender,
             'To' =>$phone,
             'Message'=>$content
        ]
    ];
   $result = $this->GuzzleClient->post('SendTextMessage', $options);
       $resultBody  =$result->getBody();
       $resultContents = $resultBody->getContents();
       $xml = simplexml_load_string($resultContents );
      $encoded_xml = json_encode($xml);
      $json_to_arr =json_decode($encoded_xml,true);

      //positive means sms delivered //error cdde 0 means no error
      if($json_to_arr['ServiceClass']['Status'] >= 0)
      {

        $logArray =[
        'from'=>$this->Sender,
        'to'=>$phone,
        'message'=>$content,
        'status'=>$json_to_arr['ServiceClass']['Status'],
        'status_text'=>$json_to_arr['ServiceClass']['StatusText'],
        'message_id'=>$json_to_arr['ServiceClass']['MessageId']
        ];
        return $this->saveSmslog($logArray);

      }

      else{

      //   return response()->json([
      //       'status' => 0,
      //      'message' => 'SMS sending Failed',
      //  ]);

      return 0;//failed to send

      }


}

  public function saveSmslog(array $data){

     $log = SmsLog::create([
         'from' =>  $data['from'],
         'to'  =>   $data['to'],
         'message'=>$data['message'],
         'status'=> $data['status'],
         'status_text'=>$data['status_text'],
         'message_id'=>$data['message_id']
     ]);

     if(is_null($log))
     {
     return response()->json([
       'status' => 0,
       'message' => 'SMS logging failed',
     ]);

     }

     return  1; //sms sent
    //  return response()->json([
    //      'status' => 1,
    //     'message' => 'SMS sent',
    // ]);

  }
}
