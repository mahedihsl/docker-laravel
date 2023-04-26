<?php

namespace App\Service\Microservice;

class CarMicroservice extends BaseService
{
  const SERVICE_NAME = 'car';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }
  
  public function list($filter = [])
  {
    return $this->get('/car/list', $filter);
  }

  public function assignRoute($data)
  {
    return $this->post('/trip/assign-route', $data);
  }
}
