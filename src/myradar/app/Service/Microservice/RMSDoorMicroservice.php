<?php

namespace App\Service\Microservice;

class RMSDoorMicroservice extends BaseService
{
  const SERVICE_NAME = 'rms-door';

  public function __construct()
  {
    parent::__construct(self::SERVICE_NAME);
  }

  public function openhours($query)
  {
    return $this->get('/api/open-hours', $query);
  }

  public function getEvents($query)
  {
    return $this->get('/api/events', $query);
  }

  public function getAccessRecords($query)
  {
    return $this->get('/access/fetch-records', $query);
  }

  public function saveAccessRecord($data)
  {
    return $this->post('/access/save-record', $data);
  }

  public function getAccessCards($query)
  {
    return $this->get('/access/fetch-cards', $query);
  }

  public function addAccessCard($data)
  {
    return $this->post('/access/add-card', $data);
  }

  public function deleteAccessCard($data)
  {
    return $this->post('/access/delete-card', $data);
  }
 
  public function clearAccessCardList($data)
  {
    return $this->post('/access/clear-cards', $data);
  }
}
