<?php

namespace App\Consumer;

use App\Consumer\ConsumerInterface;

/**
 * @class ServiceConsumer
 */
abstract class ServiceConsumer implements ConsumerInterface
{
    protected $data;

    function __construct($data)
    {
        $this->data = $this->transform($data);
    }

    protected function getData()
    {
        return $this->data;
    }

    public function count()
    {
        return 1;
    }

    /**
     * Transforms the data and
     * stores into $this->data
     */
    abstract protected function transform($data);

}
