<?php

namespace App\Service\Microservice;

class PushMicroservice extends BaseService
{
  const SERVICE_NAME = 'push';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function send($user_id, $payload)
  {
    return $this->post('/send', compact('user_id', 'payload'));
  }
}
