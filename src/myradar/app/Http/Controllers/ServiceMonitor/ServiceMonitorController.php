<?php

namespace App\Http\Controllers\ServiceMonitor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\Device;
use App\Entities\User;
use App\Entities\Service;
use App\Entities\Position;
use App\Entities\ServiceLog;
use App\Entities\ServiceString;
use App\Entities\FuelHistory;
use App\Entities\GasHistory;
use App\Entities\Health;
use App\Entities\Ibs;
use App\Entities\ExecTime;
use Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Service\Microservice\FuelMicroservice;

class ServiceMonitorController extends Controller
{

  public function show(Request $request)
  {
    $users = [];
    $user_list = User::orderBy('name')->get();
    $length = sizeof($user_list);


    $inc =0;
    foreach($user_list as $key => $user):
     $users[$inc]["text"] = $user->name;
     $users[$inc]["id"] = $user->id;
     $inc++;
    endforeach;

    $services = [];
    $service_list = Service::orderBy('created_at', 'asc')->get();
    $services[777] = "Device Health";
    foreach($service_list as $service):
     $services[$service->sid] = $service->name;
    endforeach;



    $from = $request->get('from_date');
    $to = $request->get('to_date');
    $user_id =$request->get('user_id', null);
    $device_id =$request->get('device_id', null);
    $service_id =$request->get('service_id', null); //sid (1-20)
    $user_name = $request->get('autoComplete', null);

    if(isset($user_id))
    {
    $Device = Device::where('_id', $device_id)->orWhere('com_id', intval($device_id))->first();
    $User = User::find($user_id)->name;
    }

    if(isset($from) && isset($to))
    {
    $from_date = Carbon::createFromFormat('m/d/Y H:i A', $from);
    $to_date = Carbon::createFromFormat('m/d/Y H:i A', $to);
    }

  $sid=$service_id;
  $file_name = "Export";
  $headings = [];
  if(isset($sid))
  {
    $st_time = new \MongoDB\BSON\UTCDateTime($from_date->timestamp * 1000);
    $en_time = new \MongoDB\BSON\UTCDateTime($to_date->timestamp * 1000);
    $curr_page = intval($request->get('page', '1'));
    $per_page = 25;

	  if($sid==20)//ibs
    {
      $data = Ibs::where('device_id',$Device->id)
              ->where('created_at','<',$to_date)
              ->where('created_at','>',$from_date)
              ->select(['created_at', 'value'])
              ->orderBy('created_at', 'desc')
        ->paginate(20);

          $file_name = "IBS_Export_".$User;
          $headings = array('Date Time', 'IBS Value');
    }
    if($sid==16)//fuel
      {
        $query = [
          '$and' => [
            ['device_id' => ['$eq' => $Device->id]],
            ['when' => ['$gt' => $st_time]],
            ['when' => ['$lt' => $en_time]],
          ]
        ];
        $options = [
          'skip' => ($curr_page - 1) * $per_page,
          'limit' => $per_page,
          'sort' => ['when' => -1],
          'projection' => [
            'when' => true,
            'value' => true,
          ]
        ];

        $total = FuelHistory::raw(function($collection) use ($query) {
          return $collection->count($query);
        });
        $items = FuelHistory::raw(function($collection) use ($query, $options) {
          return $collection->find($query, $options);
        });
        $data = new LengthAwarePaginator($items, $total, $per_page, $curr_page);

            $file_name = "Fuel_Export_".$User;
           $headings = array('Date Time', 'Fuel Value');

      }

      if($sid==777)//health
        {
          $query = [
            '$and' => [
              ['device_id' => ['$eq' => $Device->id]],
              ['created_at' => ['$gt' => $st_time]],
              ['created_at' => ['$lt' => $en_time]],
            ]
          ];
          $options = [
            'skip' => ($curr_page - 1) * $per_page,
            'limit' => $per_page,
            'sort' => ['created_at' => -1],
          ];
          $total = Health::raw(function($collection) use ($query) {
            return $collection->count($query);
          });
          $items = Health::raw(function($collection) use ($query, $options) {
            return $collection->find($query, $options);
          });
          $data = new LengthAwarePaginator($items, $total, $per_page, $curr_page);
  
              $file_name = "Health_Export_".$User;
             $headings = array('Date Time','Loop Count', 'Engine Status', 'Setup Time(Second)','Avg Loop Time(Second)','Min Loop Time(Second)','Max Loop Time(Second)','Min free Ram','Max Free Ram', 'Shield Count', 'GPS Power', 'MCUCSR');
        }

      if($sid==17)//gas
        {
          $query = [
            '$and' => [
              ['device_id' => ['$eq' => $Device->id]],
              ['when' => ['$gt' => $st_time]],
              ['when' => ['$lt' => $en_time]],
            ]
          ];
          $options = [
            'skip' => ($curr_page - 1) * $per_page,
            'limit' => $per_page,
            'sort' => ['when' => -1],
            'projection' => [
              'when' => true,
              'value' => true,
            ]
          ];

          $total = GasHistory::raw(function($collection) use ($query) {
            return $collection->count($query);
          });
          $items = GasHistory::raw(function($collection) use ($query, $options) {
            return $collection->find($query, $options);
          });
          $data = new LengthAwarePaginator($items, $total, $per_page, $curr_page);

          $file_name = "Gas_Export_".$User;
           $headings = array('Date Time', 'Gas Value');
        }

        if($sid == 23) { // Service String
          {
            $query = [
              '$and' => [
                ['com_id' => ['$eq' => $Device->com_id]],
                ['created_at' => ['$gt' => $st_time]],
                ['created_at' => ['$lt' => $en_time]],
              ]
            ];
            $options = [
              'skip' => ($curr_page - 1) * $per_page,
              'limit' => $per_page,
              'sort' => ['created_at' => -1],
              'projection' => [
                'data' => true,
                'created_at' => true,
              ]
            ];
  
            $total = ServiceString::raw(function($collection) use ($query) {
              return $collection->count($query);
            });
            $items = ServiceString::raw(function($collection) use ($query, $options) {
              return $collection->find($query, $options);
            });
            $data = new LengthAwarePaginator($items, $total, $per_page, $curr_page);
  
            $file_name = "Service_String_Export_".$User;
            $headings = array('Date Time', 'Service String');
          }
        }

        if ($sid == 21) {
          $fuelService = new FuelMicroservice();
          $first_avarage_type = 1;
          $data = $fuelService->fetchAvarage($Device->id, $from_date->timestamp, $to_date->timestamp, $curr_page, $per_page, $first_avarage_type);
          $items = collect($data['items'])->map(function($row) {
            return (object) $row;
          });
          $data = new LengthAwarePaginator($items, $data['total'], $per_page, $curr_page);
          $file_name = "Fuel_Avarage_Export_".$User;
          $headings = array('Date Time', '1st Avg. Fuel Value');
        }
        
        if ($sid == 22) {
          $fuelService = new FuelMicroservice();
          $second_avarage_type = 2;
          $data = $fuelService->fetchAvarage($Device->id, $from_date->timestamp, $to_date->timestamp, $curr_page, $per_page, $second_avarage_type);
          $items = collect($data['items'])->map(function($row) {
            return (object) $row;
          });
          $data = new LengthAwarePaginator($items, $data['total'], $per_page, $curr_page);
          $file_name = "Fuel_Avarage_Export_".$User;
          $headings = array('Date Time', '2nd Avg. Fuel Value');
        }

        if($sid==0)//Lat lng
          {
            $query = [
              '$and' => [
                ['device_id' => ['$eq' => $Device->id]],
                ['when' => ['$gt' => $st_time]],
                ['when' => ['$lt' => $en_time]],
              ]
            ];
            $options = [
              'skip' => ($curr_page - 1) * $per_page,
              'limit' => $per_page,
              'sort' => ['when' => -1],
              'projection' => [
                'when' => true,
                'lat' => true,
                'lng' => true,
              ]
            ];
            $total = Position::raw(function($collection) use ($query) {
              return $collection->count($query);
            });
            $items = Position::raw(function($collection) use ($query, $options) {
              return $collection->find($query, $options);
            });
            $data = new LengthAwarePaginator($items, $total, $per_page, $curr_page);

          $file_name = "Lat_Long_Export_".$User;
           $headings = array('Date Time', 'Lat','Long');
          }

      }


      if ($request->has('export') && $request->get('export') =="1") { //export  all
                   Excel::create("".$file_name, function($excel) use($data,$sid,$headings,$Device,$from_date,$to_date) {
                    $exportResult=[];

                     if($sid==0)
                     {
                       $data = Position::where('device_id',$Device->id)
                              ->where('when','<',$to_date)
                              ->where('when','>',$from_date)
                              ->select('when','lat','lng')
                               ->orderBy('when','asc')->get();

                     foreach ($data as $data) {
                       $exportResult[] = [
                         $data->when->format('d M Y g:i:s A'),
                         'xx.xxxx',
                         'xx.xxxx'
                       ];

                       }
                    }

                    else if ($sid == 21) {
                      $page = 1;
                      $perPage = 1000000;
                      $fuelService = new FuelMicroservice();
                      $avarage_type = 1;
                      $data = $fuelService->fetchAvarage($Device->id, $from_date->timestamp, $to_date->timestamp, $page, $perPage, $avarage_type);
                      $items = collect($data['items'])->reverse()->map(function($row) {
                        return (object) $row;
                      });
                      foreach ($items as $item) {
                        $exportResult[] = [
                          Carbon::parse($item->when)->format('d M Y g:i:s A'),
                          $item->value
                        ];
                      }
                    }
                    
                    else if ($sid == 22) {
                      $page = 1;
                      $perPage = 1000000;
                      $fuelService = new FuelMicroservice();
                      $avarage_type = 2;
                      $data = $fuelService->fetchAvarage($Device->id, $from_date->timestamp, $to_date->timestamp, $page, $perPage, $avarage_type);
                      $items = collect($data['items'])->reverse()->map(function($row) {
                        return (object) $row;
                      });
                      foreach ($items as $item) {
                        $exportResult[] = [
                          Carbon::parse($item->when)->format('d M Y g:i:s A'),
                          $item->value
                        ];
                      }
                    }

                    else if ($sid == 23) { // service string
                      $data = ServiceString::where('com_id',$Device->com_id)
                             ->where('created_at','<',$to_date)
                             ->where('created_at','>',$from_date)
                             ->select('data','created_at')
                             ->orderBy('created_at','asc')->get();

                      foreach ($data as $data) {
                        $exportResult[] = [
                          $data->created_at->format('d M Y g:i:s A'),
                          $data->data
                        ];
                      }
                    }

                    else if($sid==16){

                      $data = FuelHistory::where('device_id',$Device->id)
                             ->where('when','<',$to_date)
                             ->where('when','>',$from_date)
                             ->select('when','value')
                             ->orderBy('when','asc')->get();

                      foreach ($data as $data) {
                        $exportResult[] = [
                          $data->when->format('d M Y g:i:s A'),
                          $data->value
                        ];
                      }
                    }
                    else if($sid==17){
                      $data=  GasHistory::where('device_id',$Device->id)
                             ->where('when','<',$to_date)
                             ->where('when','>',$from_date)
                             ->select('when','value')
                             ->orderBy('when','asc')
                             ->get();

                      foreach ($data as $data) {
                        $exportResult[] = [
                          $data->when->format('d M Y g:i:s A'),
                          $data->value
                        ];

                        }

                    }

                    else if($sid==777){

                      $data=  Health::where('device_id',$Device->id)
                             ->where('created_at','<',$to_date)
                             ->where('created_at','>',$from_date)
                             //->select('when','value')
                             ->orderBy('created_at','asc')->get();


                      foreach ($data as $data) {
                        $exportResult[] = [
                          $data->created_at->format('d M Y g:i:s A'),
                           $data->loop_count,
                           $data->es,
                           $data->setup_time/1000,
                           $data->avg_loop_time/1000,
                           $data->min_loop_time/1000,
                           $data->max_loop_time/1000,
                           $data->min_free_ram,
                           $data->max_free_ram,
                           $data->shield_count,
                           $data->gps_power,
                           $data->mcucsr(),
                        ];

                        }
                    }

                    $result = $exportResult;
                    $excel->sheet('First sheet', function($sheet) use($result,$headings) {
                    $sheet->fromArray($result, null, 'A1', false, false);
                    $sheet->prependRow(1, $headings);
                 });

             })->export('xls');
      }
          return view('service.monitor')->with([
            'services'=>$services,
            'users'=> json_encode($users),
            'histories'=>isset($data)?$data:null,
            //'health'=>'',
            'sid'=>$sid,
            'from_date'=>isset($from_date)?$from_date:null,
            'to_date'=>isset($to_date)?$to_date:null,
            'user_id' => $user_id,
            'user_name' => $user_name,
            'device_id' => $device_id,
            'service_id' => $service_id,
          ]);

}


}
