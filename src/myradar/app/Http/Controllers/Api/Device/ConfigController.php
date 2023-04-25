<?php

namespace App\Http\Controllers\Api\Device;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\Device;
use App\Service\Microservice\DeviceMicroservice;
use App\Service\Microservice\ET200Microservice;

class ConfigController extends Controller
{
  /**
   * @var DeviceMicroservice
   */
  private $service;
  private $concox;

  public function __construct() {
    $this->service = new DeviceMicroservice();
    $this->concox = new ET200Microservice();
  }

  public function fetch(Request $request)
  {
    try {
      $device_id = $request->get('device_id');
      $res = $this->service->deviceConfig($device_id);
      $transition = false;
      try {
        $device = Device::find($device_id);
        $info = $this->concox->status($device->com_id);
        $transition = $info['transition'];
        $res['engine_status'] = boolval($info['synthetic_engine']);
      } catch (\Exception $th) {}
      $res['transition'] = $transition;
      return response()->json($res);
    } catch (\Exception $th) {
      return response()->json(['message' => $th->getMessage()]);
    }
  }
}