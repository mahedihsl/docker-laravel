<?php

namespace App\Http\Controllers\Api\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Microservice\UserMicroservice;
use App\Service\Microservice\ServiceException;

class SessionController extends Controller
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserMicroservice();
    }

    public function register(Request $request) {
        try {
            $data = $request->all();
            $data['user_id'] = $request->user()->id;
            unset($data['api_token']);
            $reply = $this->userService->registerSession($data);
            return response()->json($reply);
        } catch (ServiceException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function logout(Request $request) {
        try {
            $data = $request->all();
            $data['user_id'] = $request->user()->id;
            unset($data['api_token']);
            $reply = $this->userService->removeSessionsOfUser($data);
            return response()->json($reply);
        } catch (ServiceException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
