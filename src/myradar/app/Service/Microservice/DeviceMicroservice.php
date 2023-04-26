<?php

namespace App\Service\Microservice;

class DeviceMicroservice extends BaseService
{
  const SERVICE_NAME = 'device';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function bindDevice($car_id, $com_id)
  {
    return $this->post('/car/bind', compact('car_id', 'com_id'));
  }

  public function unbindDevice($car_id)
  {
    return $this->post('/car/unbind', compact('car_id'));
  }

  public function bindWithSite($data)
  {
    return $this->post('/device/bind-with-site', $data);
  }

  public function unbindFromSite($data)
  {
    return $this->post('/device/unbind-from-site', $data);
  }

  public function bindHistory($params)
  {
    return $this->get('/car/bind/history', $params);
  }

    public function allBindRecords()
    {
        return $this->get('/car/bind/records');
    }

  public function deviceConfig($device)
  {
    return $this->get('/device/config', compact('device'));
  }

  public function list($filter)
  {
    return $this->get('/device/list', $filter);
  }

  public function consumeEngineStatus($com_id, $status)
  {
    return $this->post('/engine/consume', compact('com_id', 'status'));
  }
  
  public function getRmsPinConfig($query)
  {
    return $this->get('/rms-config/filter', $query);
  }
  
  public function saveRmsPinConfig($data)
  {
    return $this->post('/rms-config/save', $data);
  }
  
  public function updateRmsPinConfig($data)
  {
    return $this->post('/rms-config/update', $data);
  }
  
  public function removeRmsPinConfig($data)
  {
    return $this->post('/rms-config/remove', $data);
  }
}
