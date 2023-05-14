<?php

namespace App\Mapper;

use Illuminate\Http\Request;

class DeviceCreateMapper extends DataMapper
{

    function __construct($data)
    {
        parent::__construct($data);
    }

    protected function getMap() {
        return [
            'name' => 'name',
            'model' => 'model',
            'maker' => 'manufacturer_id',
            'sim_no' => 'sim_no',
            'reg_no' => 'reg_no',
            'reg_date' => 'reg_date|time,m/d/Y',
            'tax_date' => 'tax_date|time,m/d/Y',
            'fitness_date' => 'fitness_date|time,m/d/Y',
            'insurance_date' => 'insurance_date|time,m/d/Y',
            'engine_no' => 'engine_no',
            'chesis_no' => 'chesis_no',
            'color' => 'color|integer',
            'type' => 'type|integer',
            'fuel' => 'fuel_type|integer',
            'engine_cc' => 'engine_cc|integer',
            'seat_count' => 'seat_count|integer',
            'cng' => 'cng|boolean',
            'note' => 'note',
        ];
    }
}
