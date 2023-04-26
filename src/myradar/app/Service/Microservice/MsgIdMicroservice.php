<?php

namespace App\Service\Microservice;

class MsgIdMicroservice extends BaseService
{
  const SERVICE_NAME = 'msgid';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function next()
  {
    return $this->get('/api/new-id');
  }
}
