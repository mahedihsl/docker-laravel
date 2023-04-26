<?php

namespace App\Service\Microservice;

/**
 * Created for tessting purpose, safe to delete
 */
class SocketMicroservice extends BaseService
{
  const SERVICE_NAME = 'socket';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function send($data)
  {
    return $this->post('/io/send', $data);
  }
}
