<?php

namespace App\Service\Microservice;

class PaymentMicroservice extends BaseService
{
  const SERVICE_NAME = 'payment';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function observeBill($payment_id)
  {
    return $this->post('/bill/observe', compact('payment_id'));
  }
}
