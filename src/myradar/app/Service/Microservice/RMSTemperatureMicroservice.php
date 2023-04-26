<?php

namespace App\Service\Microservice;

class RMSTemperatureMicroservice extends BaseService
{
  const SERVICE_NAME = 'rms-temperature';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function recent($query)
  {
    return $this->get('/api/recent', $query);
  }
  
  public function aggregate($query)
  {
    return $this->get('/api/aggregate', $query);
  }
  
  public function getCriticalSites($query)
  {
    return $this->get('/analytics/critical-sites', $query);
  }
  
  public function getEvents($query)
  {
    return $this->get('/api/events', $query);
  }
}
