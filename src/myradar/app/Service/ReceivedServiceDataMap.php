<?php

namespace App\Service;

use App\Entities\Service;
use GuzzleHttp;

class ReceivedServiceDataMap
{

    public function checkServiceValues($sid, $value,$service_type)

    {
        //eg 1,2,3..






    }


    public function serviceTypes()
    {

        $get_services = Service::all()->toArray();

        echo json_encode($get_services, True);

    }


}
