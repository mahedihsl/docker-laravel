<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Microservice\ServiceException;
use App\Service\Microservice\UserMicroservice;

class SessionController extends Controller
{
    /**
     * @var UserMicroservice
     */
    private $userService;

    public function __construct()
    {
        $this->userService = new UserMicroservice();
    }

    public function all(Request $request)
    {
        try {
            $user_id = $request->get('user_id');
            return response()->json($this->userService->getSessionList($user_id));
        } catch (ServiceException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function remove(Request $request)
    {
        try {
            $session_id = $request->get('session_id');
            $this->userService->removeSessionById($session_id);
            return response()->json(['status' => 'ok']);
        } catch (ServiceException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function logout(Request $request)
    {
        $session_id = $request->get('session_id');
        $this->userService->forceLogout($session_id);
        return response()->json(['status' => 'ok']);
    }
}
