<?php

namespace App\Mapper;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Mapper\DataExtractor;

abstract class DataMapper
{
    use DataExtractor;

    private $data;

    function __construct($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        $map = $this->getMap();
        $data = collect([]);

        foreach ($map as $key1 => $key2) {
            $conf = $this->extractKey($key2);

            $key = $conf['key'];
            $type = isset($conf['type']) ? $conf['type'] : 'string';
            $flag = true;

            switch ($type) {
                case 'integer':
                    $val = $this->getInteger($this->data, $key1);
                    break;
                case 'float':
                    $val = $this->getFloat($this->data, $key1);
                    break;
                case 'boolean':
                    $val = $this->getBoolean($this->data, $key1);
                    break;
                case 'time':
                    $val = $this->getDate($this->data, $key1, $conf['arg']);
                    break;
                case 'string':
                    $val = $this->getString($this->data, $key1);
                    break;

                default:
                    $flag = false;
                    break;
            }

            if ($flag) {
                $data->put($key, $val);
            }
        }

        return $data->toArray();
    }

    private function extractKey($key) {
        $ret = array();
        $arr = explode("|", $key);
        $ret['key'] = $arr[0];

        if (isset($arr[1])) {
            $arr2 = explode(",", $arr[1]);
            $ret['type'] = $arr2[0];

            if (isset($arr2[1])) {
                $ret['arg'] = $arr2[1];
            }
        }

        return $ret;
    }

    abstract protected function getMap();

}
