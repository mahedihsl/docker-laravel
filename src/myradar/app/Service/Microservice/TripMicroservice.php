<?php

namespace App\Service\Microservice;

class TripMicroservice extends BaseService
{
  const SERVICE_NAME = 'trip';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }
  
  public function history($filter = [])
  {
    return $this->get('/api/history', $filter);
  }
  
  public function test($params)
  {
    return $this->post('/api/test', $params);
  }
}
