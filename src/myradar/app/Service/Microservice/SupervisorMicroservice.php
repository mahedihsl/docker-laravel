<?php

namespace App\Service\Microservice;

class SupervisorMicroservice extends BaseService
{
  const SERVICE_NAME = 'supervisor-aws';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function runningServer()
  {
    return $this->get('/api/running-server');
  }
}
