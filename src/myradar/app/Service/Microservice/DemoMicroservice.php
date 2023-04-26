<?php

namespace App\Service\Microservice;

class DemoMicroservice extends BaseService
{
  const SERVICE_NAME = 'demo';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function moveVessel($index)
  {
    return $this->post('/api/move-vessel', compact('index'));
  }
}
