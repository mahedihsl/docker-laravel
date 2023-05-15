<?php

namespace App\Service\Refuel;
use Illuminate\Support\Collection;


abstract class DataLog
{
    /**
     * @var Collection
     */
    protected $log;

    function __construct(Collection $records)
    {
        $this->log = $records->map(function($item) {
            return ['value' => $item->value];
        });
    }

}
