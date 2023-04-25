<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Microservice\ServiceException;
use App\Service\Microservice\UserMicroservice;

class LoginController extends Controller {
  private $service;

  public function __construct() {
    $this->service = new UserMicroservice();
  }

  public function login(Request $request)
  {
    try {
      // $phone = $request->get('phone');
      // $password = $request->get('password');
      
      return response()->json($this->service->login($request->all()));
    } catch (\Throwable $e) {
      return response()->json(['message' => $e->getMessage()], 400);
    }
  }

  public function profile(Request $request)
  {
    try {
      $bearerToken = $request->get('token');
      $profile = $this->service->profile($bearerToken);
      return response()->json($profile);
    } catch (ServiceException $e) {
      return response()->json(['message' => $e->getMessage()], 400);
    }
  }
  
  public function refresh(Request $request)
  {
    try {
      $refreshToken = $request->get('refresh_token');
      $token = $this->service->refresh($refreshToken);
      return response()->json($token);
    } catch (ServiceException $e) {
      return response()->json(['message' => $e->getMessage()], 400);
    }
  }
}