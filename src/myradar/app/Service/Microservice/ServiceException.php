<?php

namespace App\Service\Microservice;

class ServiceException extends \Exception
{
  public $data;

  public function __construct($message, $code = 400, $data)
  {
    parent::__construct($message);
    $this->statusCode = $code;
    $this->data = $data;
  }

  public function getStatusCode()
  {
    return $this->statusCode;
  }

  public static function fromClientException($e)
  {
    $response = $e->getResponse()->getBody()->getContents();
    $response = json_decode($response, true);
    return new ServiceException($response['message'], $e->getResponse()->getStatusCode(), $response);
  }

  public static function fromServerException($e)
  {
    return new ServiceException('Unknown error !!!', $e->getResponse()->getStatusCode(), null);
  }
}
