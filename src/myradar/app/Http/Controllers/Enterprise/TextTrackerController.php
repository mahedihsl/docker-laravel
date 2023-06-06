<?php

namespace App\Http\Controllers\Enterprise;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\FenceRepository;
use App\Service\DirectionService;
use App\Criteria\UserIdCriteria;
use App\Presenters\FencePresenter;
use App\Entities\Device;
use App\Entities\Poi;
use App\Entities\Car;
use App\Entities\Thana;
use App\Entities\District;
use App\Entities\Assignment;
use App\Entities\Driver;
use App\Entities\Employee;
use Carbon\Carbon;
class TextTrackerController extends Controller
{
    /**
     * @var FenceRepository
     */

     public function __construct(FenceRepository $repository)
     {
         $this->repository = $repository;
     }

    public function show(Request $request)
    {
      return view('enterprise.tracker')->with([
          'userId' => $request->user()->id,
      ]);
    }

    public function locations(Request $request, $carId)
    {

      $car = Car::find($carId);
      $driver = Driver::where('car_id', $carId)->first();
      $device = Device::where('car_id',$carId)->first();
      $status = "-";

      if(!is_null($driver) && !is_null($device))
      {
        $time = Carbon::now();
        $status = Assignment::where('from','<', $time)->where('to','>', $time)->where('driver_id', '=', $driver->id)->exists();
      }
      $nullresponse = ['poi' => '-', 'distance' => 'N/A', 'thana' =>'-', 'district' =>'-', 'status' => $status];

      if(is_null($device)){
        return response()->json($nullresponse);
      }

      $lastpos = $device->meta->get('pos');
      $this->repository->setPresenter(FencePresenter::class);

      if(is_null($lastpos)){
        return response()->json($nullresponse);
      }

      $nearestPoi = $this->repository->scopeQuery(function($query) use ($lastpos) {
          return $query->where('loc','near', [$lastpos['lng'], $lastpos['lat']] );
      })->first();
      $dirserv = new DirectionService;
      $distance = $dirserv->distance($lastpos['lat'], $lastpos['lng'], $nearestPoi['data']['lat'], $nearestPoi['data']['lng'])/1000;
      $distance =round($distance,1);
     //dd($nearestPoi);

      $thana = Thana::find($nearestPoi['data']['thana_id']);
      $district = District::find($thana->district_id);




      return response()->json(['poi' => $nearestPoi['data']['name'], 'distance' => $distance, 'thana' => $thana->name, 'district' => $district->name, 'status' => $status]);
    }

    public function assignmentInfo(Request $request, $driverId)
    {
      $time = Carbon::NOw();
      $assignment = Assignment::where('driver_id', '=', $driverId)->where('to','>', $time)->first();
      $start = $assignment->start;
      $dest = $assignment->dest;

      $driver = Driver::find($driverId);
      $driverName = $driver->name;
      $driverPhone = $driver->phone;
      $driverId = $driver->id;

      $car = Car::where('_id', '=', $driver->car_id)->first();
      $reg_no = $car->reg_no;

      //$from = Carbon::parse($assignment->from, 'UTC'); // comment this
      //$to = Carbon::parse($assignment->to, 'UTC'); //comment this
      $duration = $assignment->duration;
      //$when = Carbon::parse($driver->from, 'UTC');
      // format carbon instance like this: $assignment->from->format("d m Y")
      $date = $assignment->from->format("d M Y h:i A");
      $employeeName = null;
      $employeePhone = null;


      //$employee = Employee::where('id','=', $assignment->employee_id)->first();
      $employee = Employee::find($assignment->employee_id);
      if(!is_null($employee))
      {
        $employeeName = $employee->name;
        $employeePhone = $employee->phone;
      }
      $message  = $assignment->message;

      //$date = $when->toDateTimeString();

      $type = $assignment->type;

      return response()->json(['type'=>$type, 'driverId' => $driverId, 'driverName' => $driverName, 'driverPhone'=>$driverPhone, 'reg_no' => $reg_no, 'employeeName' => $employeeName, 'employeePhone' => $employeePhone, 'message' => $message, 'start' => $start, 'dest' =>$dest, 'date' => $date, 'duration' => $duration]);
    }
    public function thanalist(Request $request, $districtName){
      $district = District::where('name',$districtName)->first();

      $thana = Thana::orderBy('name', 'asc')->where('district_id',$district->id)->get();

      return response()->json(['thanalist'=>$thana]);
    }
}
