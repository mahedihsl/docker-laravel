<?php

namespace App\Http\Controllers\Customer;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\PositionRepository;
use App\Presenters\PositionPresenter;
use App\Criteria\DeviceIdCriteria;
use App\Criteria\DateRangeCriteria;
use App\Criteria\OrderByWhenCriteria;
use App\Entities\Device;

class PositionHistoryController extends Controller
{
    /**
     * @var PositionRepository
     */
    private $repository;

    public function __construct(PositionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function show(Request $request, $id)
    {
        $user = User::find($id);

        if ( ! is_null($user)) {
            return view('position.history')->with([
                'user' => $user,
            ]);
        }

        return redirect()->back();
    }

    public function history(Request $request)
    {
        $user = User::find($request->get('id'));
       // print_r($user);
        $live_tracking = false;
        $from_t = $request->get('from_hr') . ':' . $request->get('from_mn') . ' ' . $request->get('from_am');
        $to_t = $request->get('to_hr') . ':' . $request->get('to_mn') . ' ' . $request->get('to_am');

        $from_t = $request->get('date') . ' ' . $from_t;
        $to_t = $request->get('date') . ' ' . $to_t;

         if($request->get('type')==1)
           {
              $live_tracking  = true;
              $Carbon = Carbon::now();
             $today = $Carbon;
           }
           elseif($request->get('type')==0){

             $from = Carbon::createFromFormat('m/d/Y h:i A', $from_t);
             $to = Carbon::createFromFormat('m/d/Y h:i A', $to_t);

           }

        if ( ! is_null($user)) {
            $cars = $user->cars;

            $data = collect([]);
            if($live_tracking==false)
            {
            foreach ($cars as $key => $car) {
                $pos = $car->device->positions()
                    ->where('when', '>=', $from)
                        ->where('when', '<=', $to)
                            ->orderBy('when', 'asc')
                                ->select(['lat', 'lng','when'])
                                    ->paginate();

                $data->put($car->device->id, $pos->getCollection());
            }

          }
          else{
            foreach ($cars as $key => $car) {

                $pos = $car->device->positions()
                    ->where('when', '>=', $today)
                            ->orderBy('when', 'asc')
                                ->select(['lat', 'lng'])
                                    ->paginate();

                $data->put($car->device->id, $pos->getCollection());
            }

        //  $pusher->trigger( 'map-channel', 'map-event', 'Data Sent');

          }

          return response()->json([
               'status' => 1,
               'data' => $data,
           ]);
        }

        else{
            return response()->json([ 'status' => 0, ]);
          }
    }

    public function getPositions(Request $request, $deviceId, $start, $finish, $skip)
    {
        $positions = $this->repository->setPresenter(PositionPresenter::class)
                        ->pushCriteria(new DeviceIdCriteria($deviceId))
                        ->pushCriteria(new DateRangeCriteria($start, $finish))
                        ->pushCriteria(new OrderByWhenCriteria())
                        ->all();

        return response()->json($positions);
    }

    public function getLastPosition(Request $request, $deviceId)
    {
        $device = Device::find($deviceId);
        $position = $this->repository->lastPosition($deviceId);
        if ( ! is_null($position)) {
            return response()->json([
                'pos' => $position,
                'meta' => [
                    'engine' => $device->engine_status,
                ]
            ]);
        }

        return response()->error('No Position Found');
    }
}
