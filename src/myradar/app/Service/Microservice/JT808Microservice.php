<?php

namespace App\Service\Microservice;

class JT808Microservice extends BaseService
{
  const SERVICE_NAME = 'jt808';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function lock($com_id)
  {
    return $this->post('/api/lock', compact('com_id'));
  }

  public function unlock($com_id)
  {
    return $this->post('/api/unlock', compact('com_id'));
  }

  public function status($com_id)
  {
    return $this->get('/api/status', compact('com_id'));
  }
}
