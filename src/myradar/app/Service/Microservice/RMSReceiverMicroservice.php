<?php

namespace App\Service\Microservice;

class RMSReceiverMicroservice extends BaseService
{
  const SERVICE_NAME = 'rms-receiver';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function receive($data)
  {
    return $this->post('/api/receive', $data);
  }
}
