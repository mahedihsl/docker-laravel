<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\SmsService;
use App\Service\NotificationService;
use App\Entities\User;

class PromotionController extends Controller
{
    //
    public function __construct()
    {

    }
    public function message(Request $request)
    {
      //$user = User::find($request->get('user_id'));
        $id = $request->id;
        $user = User::find($id);
        $message=$request->messagebody;
        if(!is_null($user)){
          $SmsService = new SmsService();
          $response = $SmsService->send($user->phone , $message);
          return response()->json([ 'status' => 1 ]);
        }

        return response()->json([ 'status' => 0 ]);
    }
    public function notification(Request $request)
    {
        $id = $request->id;
        $title = $request->title;
        $body = $request->body;
        $data = collect([
            'title' => $title,
            'body' => $body,
            'type' => 1,
        ]);


        $user = User::find($id);
        $service = new NotificationService();
        if ( ! is_null($user)) {
            $service->send($data, $user->getDeviceTokens());
            return response()->json([ 'status' => 1 ]);
        }
        return response()->json([ 'status' => 0 ]);
    }
}
