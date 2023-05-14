<?php

namespace App\Http\Controllers\RMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Microservice\RMSUserMicroservice;

class UserController extends Controller
{
  private $rmsUserService;

  public function __construct()
  {
    $this->rmsUserService = new RMSUserMicroservice();
  }

  public function updateProfile(Request $request)
  {
    try {
      $response = $this->rmsUserService->updateProfile($request->all());
      return response()->json($response);
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
  }

  public function changePassword(Request $request)
  {
    try {
      $response = $this->rmsUserService->changePassword($request->all());
      return response()->json($response);
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
  }
}
