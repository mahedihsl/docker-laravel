<?php

namespace App\Http\Controllers\Device;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Contract\Repositories\DeviceRepository;
use App\Entities\Device;
use App\Service\ConcoxDevice;

class ConcoxController extends Controller
{
    /**
     * @var DeviceRepository
     */
    private $repository;

    public function __construct(DeviceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function test(Request $request)
    {
        // $host = "182.160.99.137";
        // $port = 5050;
        // // No Timeout 
        // set_time_limit(0);
        
        // $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
        // $result = socket_connect($socket, $host, $port) or die("Could not connect toserver\n");

        // $message = "Hello TCP";
        // socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");

        // socket_close($socket);

        // $hex2str = function ($hex) {
        //     $str = '';
        //     for($i=0;$i<strlen($hex);$i+=2) $str .= chr(hexdec(substr($hex,$i,2)));
        //     return $str;
        // };

        // $lock = intval($request->get('lock', '1')) == 1 ? 1 : 0;
        // $protocol = $lock == 1 ? '20' : '21';

        // $errno = '';
        // $errstr = '';
        // $fp = fsockopen("172.17.0.1", 5050, $errno, $errstr);
        // if (!$fp) {
        //     return "$errstr ($errno)<br />\n";
        // } else {
        //     $bytes = ['78', '78', '06', $protocol, '09', '05', '01', '09', '04', '0d', '0a'];
        //     $str = $hex2str(implode('', $bytes));
        //     fwrite($fp, $str);
        //     // while (!feof($fp)) {
        //     //     echo fgets($fp, 128);
        //     // }
        //     fclose($fp);
        //     return "connection success";
        // }

        $concox = new ConcoxDevice();

        return $concox->lock(95194, $request->get('lock', '1') == 1);
    }
}
