<?php

namespace App\Service\Microservice;

class HealthMicroservice extends BaseService
{
  const SERVICE_NAME = 'health';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function report($device_id)
  {
    return $this->get('/report/summary', compact('device_id'));
  }
}
