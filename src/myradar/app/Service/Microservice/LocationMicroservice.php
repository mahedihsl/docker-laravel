<?php

namespace App\Service\Microservice;

class LocationMicroservice extends BaseService
{
  const SERVICE_NAME = 'location';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function history($device_id, $from, $to)
  {
    return $this->get('/api/history', compact('device_id', 'from', 'to'));
  }

  public function latest($com_id)
  {
    return $this->get('/api/latest', compact('com_id'));
  }

  public function consume($data)
  {
    return $this->post('/api/consume', $data);
  }
}
