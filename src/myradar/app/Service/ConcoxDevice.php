<?php

namespace App\Service;

class ConcoxDevice {
    function __construct() {

    }

    function lock($com_id, $status) { // $status = true : lock device, status = 0 : unlock device
        $str = strval($com_id);
        $protocol = $status ? '20' : '21';
        $bytes = ['78', '78', '06', $protocol, 
            '0'.$str[0], '0'.$str[1], '0'.$str[2], '0'.$str[3], '0'.$str[4], 
            '0d', '0a'];
        return $this->command($bytes);
    }

    function command($bytes) {
        $hex2str = function ($hex) {
            $str = '';
            for($i=0;$i<strlen($hex);$i+=2) $str .= chr(hexdec(substr($hex,$i,2)));
            return $str;
        };

        $errno = '';
        $errstr = '';
        $fp = fsockopen("172.17.0.1", 5050, $errno, $errstr);
        if (!$fp) {
            return "$errstr ($errno)<br />\n";
        } else {
            $str = $hex2str(implode('', $bytes));
            fwrite($fp, $str);
            // while (!feof($fp)) {
            //     echo fgets($fp, 128);
            // }
            fclose($fp);
            return "connection success";
        }
    }
}