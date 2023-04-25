<?php

namespace App\Http\Controllers\RMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Microservice\RMSUserMicroservice;

class AuthController extends Controller
{
  private $rmsUserService;

  public function __construct()
  {
    $this->rmsUserService = new RMSUserMicroservice();
  }

  public function login(Request $request)
  {
    try {
      $response = $this->rmsUserService->loginUser($request->all());
      return response()->json($response);
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
  }

  public function refresh(Request $request)
  {
    try {
      $response = $this->rmsUserService->refreshToken($request->all());
      return response()->json($response);
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
  }

  public function user(Request $request)
  {
    try {
      // return response()->json($request->headers);
      $headers = [
        'Authorization' => app('request')->header('Authorization', '')
        // 'Authorization' => $request->headers->get('authorization')[0]
        // 'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjYxNWMxMWNhZDllNzg3MzllOGIyYzIwOSIsInVpZCI6MTAwMDIsIm5hbWUiOiJEZW1vIFJNUyIsInBob25lIjoiMDE5MDc4ODg5MDkiLCJ0eXBlIjo0LCJjdXN0b21lcl90eXBlIjo0LCJpYXQiOjE2NDgzOTA0MzV9.JY_KTLSCFIK21cWPKsG0p97x5SoCxq75HUHhzM03hV0'
      ];
      // $headers = collect($request->header())->transform(function ($item) {
      //     return $item[0];
      // })->toArray();
      $response = $this->rmsUserService->getUser($headers);
      return response()->json($response);
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
  }

  public function logout(Request $request)
  {
    try {
      $response = $this->rmsUserService->logoutUser($request->all());
      return response()->json($response);
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
  }
}
