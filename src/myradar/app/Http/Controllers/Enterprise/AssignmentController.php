<?php

namespace App\Http\Controllers\Enterprise;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\AssignmentRepository;
use App\Events\AssignmentCreated;
use App\Entities\Device;
use App\Criteria\CarIdCriteria;
use App\Criteria\InsideTimeRangeCriteria;
use App\Transformers\CarDriverTransformer;
use Carbon\Carbon;
use App\Entities\Assignment;

class AssignmentController extends Controller
{
    /**
     * @var AssignmentRepository
     */
    private $repository;

    public function __construct(AssignmentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function save(Request $request)
    {
        $model = $this->repository->save(collect($request->all()));

        return ! is_null($model) ? response()->json() : response()->error();
    }

    public function current(Request $request, $id)
    {
        try {
            $device = Device::find($id);
            $model = $this->repository
                        ->skipPresenter()
                        ->pushCriteria(new CarIdCriteria($device->car_id))
                        ->pushCriteria(new InsideTimeRangeCriteria(Carbon::now()))
                        ->first();

            $transformer = new CarDriverTransformer();
            return response()->json([
                'info' => is_null($model) ? null : $model->presenter(),
                'car' => $transformer->transform($device->car),
            ]);
        } catch (\Exception $e) {}

        return response()->error();
    }

    public function all(Request $request, $id)
    {
      $time = Carbon::NOw();
      $assignments = Assignment::where('driver_id', '=', $id)->where('to','>', $time)->get();

      return response()->json($assignments);
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
}
