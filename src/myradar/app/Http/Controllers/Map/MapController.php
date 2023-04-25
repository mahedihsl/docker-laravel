<?php

namespace App\Http\Controllers\Map;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cornford\Googlmapper\Facades\MapperFacade as Mapper;



class MapController extends Controller
{
    public function index()
    {
       Mapper::map(53.381128999999990000, -1.470085000000040000,
         ['zoom' => 10, 'markers' => ['title' => 'My Location', 'animation' => 'DROP'],
               'clusters' => ['size' => 10, 'center' => true, 'zoom' => 20]]);

        Mapper::polygon([['latitude' => 53.381128999999990000, 'longitude' => -1.470085000000040000], ['latitude' => 52.381128999999990000, 'longitude' => 0.470085000000040000]]);
        Mapper::polygon([['latitude' => 53.381128999999990000, 'longitude' => -1.470085000000040000], ['latitude' => 52.381128999999990000, 'longitude' => 0.470085000000040000]], ['editable' => 'true']);
       ///Mapper::map(52.381128999999990000, 0.470085000000040000)->polygon([['latitude' => 53.381128999999990000, 'longitude' => -1.470085000000040000], ['latitude' => 52.381128999999990000, 'longitude' => 0.470085000000040000]], ['strokeColor' => '#000000', 'strokeOpacity' => 0.1, 'strokeWeight' => 2, 'fillColor' => '#FFFFFF']);


        return view('maps.map');
    }

}
