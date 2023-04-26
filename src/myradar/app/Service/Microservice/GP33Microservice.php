<?php

namespace App\Service\Microservice;

class GP33Microservice extends BaseService
{
  const SERVICE_NAME = 'gp33';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function lock($com_id)
  {
    return $this->post('/lock', compact('com_id'));
  }

  public function unlock($com_id)
  {
    return $this->post('/unlock', compact('com_id'));
  }

  public function status($device)
  {
    return $this->get('/status', compact('device'));
  }
  
  public function test($message)
  {
    return $this->post('/command', compact('message'));
  }
}
