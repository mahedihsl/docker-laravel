<?php

namespace App\Service\Microservice;

class RMSMLKitMicroservice extends BaseService
{
  const SERVICE_NAME = 'rms-mlkit';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function getBatteryVoltageCurve($params)
  {
    return $this->post('/battery/get-curve', $params);
  }
}
