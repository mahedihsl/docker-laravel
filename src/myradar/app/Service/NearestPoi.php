<?php

namespace App\Service;
use App\Entities\DemoLocation;
/**
 *
 */
class NearestPoi
{
  private $lat,$lng;

  function __construct($lattitude, $longitude)
  {
    $lat=$lattitude;
    $lng=$longitude;
  }


  function showlatlng()
  {
    return $this->lat;
  }
 //$place= new Geolocation(23.829258, 90.357371);

function getnearestpoi(){
    $poi = DemoLocation::where('loc', 'near', [
     '$geometry' => [
            'type' => 'Point',
         'coordinates' => [
             $this->lng,
              $this->lat,
            ],
        ],
   //     '$maxDistance' => 500,
    ]);
    return $poi;
  }


}


 ?>



 db.demo_locations.insert(
    {
       loc : { type: "Point", coordinates: [ 90.377443, 23.794678 ] },
       name: "Ibrahimpur",
    }
 )
