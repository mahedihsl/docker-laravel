<?php

namespace App\Service\Microservice;

class RMSMainsMicroservice extends BaseService
{
  const SERVICE_NAME = 'rms-mains';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function recent($query)
  {
    return $this->get('/api/recent', $query);
  }
 
  public function events($query)
  {
    return $this->get('/api/events', $query);
  }

  public function offhours($query)
  {
    return $this->get('/api/offhours', $query);
  }
  
  public function exportData($query)
  {
    return $this->get('/api/export-data', $query);
  }

  public function criticalSites($query)
  {
    return $this->get('/analytics/critical-sites', $query);
  }

  public function availability($query)
  {
    return $this->get('/analytics/availability', $query);
  }
}
