<?php

namespace App\Http\Controllers\Test;

use App\Entities\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Microservice\DemoMicroservice;

class DemoController extends Controller
{
    private $microservice;

    public function __construct()
    {
        $this->microservice = new DemoMicroservice();
    }

    public function vessel(Request $request)
    {
        try {
            $index = $request->get('index');
            $res = $this->microservice->moveVessel($index);
            return response()->json($res);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function resetPassword(Request $request)
    {
        $demoEmail = 'demo@myradar.com';
        $demoUser = User::where('email', $demoEmail)->first();

        if (!$demoUser) {
            return response()->json([
                'message' => 'Demo account not found'
            ], 400);
        }

        $secret = 'pukurPara';
        if ($request->get('secret') != $secret) {
            return response()->json([
                'message' => 'Secret verification failed'
            ], 400);
        }

        $demoUser->update([ 'password' => bcrypt($request->get('password')) ]);
        return response()->json(['message' => 'Demo user password changed']);
    }
}
