<?php

namespace App\Service\Microservice;

class MileageMicroservice extends BaseService
{
  const SERVICE_NAME = 'mileage';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function history($query)
  {
    return $this->get('/api/list', $query);
  }

  public function consume($data)
  {
    return $this->post('/api/consume', $data);
  }
  
  public function recalculate($data)
  {
    return $this->post('/api/recalculate', $data);
  }
}
