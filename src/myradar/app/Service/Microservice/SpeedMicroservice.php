<?php

namespace App\Service\Microservice;

class SpeedMicroservice extends BaseService
{
  const SERVICE_NAME = 'speed';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function observe($car_id, $com_id, $speed)
  {
    return $this->post('/observe', compact('car_id', 'com_id', 'speed'));
  }

  public function update($car_id, $soft_value, $soft_active, $hard_value, $hard_active)
  {
    return $this->post('/update', compact('car_id', 'soft_value', 'soft_active', 'hard_value', 'hard_active'));
  }

  public function find($car_id)
  {
    return $this->get('/find', compact('car_id'));
  }
  
  public function test($query)
  {
    return $this->get('/test', $query);
  }

}
