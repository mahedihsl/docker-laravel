<?php

namespace App\Http\Controllers\Bus;

use App\Contract\Repositories\CarRepository;
use App\Contract\Repositories\FenceRepository;
use App\Events\FenceAttached;
use App\Events\FenceDeleted;
use App\Events\FenceCreated;
use App\Http\Requests\SaveFence;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\Car;
use App\Entities\User;
use App\Entities\Fence;

class RouteController extends Controller
{

  public function __construct(FenceRepository $repository)
  {
      $this->repository = $repository;
  }


  public function index()
  {
    return view('bus.index');
  }

  public function companies(Request $request)
  {
      //$ids = Car::where('type', '=', 4)->select('user_id')->distinct()->get();
      $ids = Car::where('type', '=', 4)->distinct()->get(['user_id'])->toArray();
      $names =collect();
      foreach ($ids as $key => $id) {

        $user = User::find($id[0]);
        $name = $user->name;
        $id = $user->id;
        $names->push(['id'=>$id, 'name'=>$name]);
      }

      return response()->json($names);
  }

  public function buses(Request $request, $id)
  {
    $buses = Car::where('user_id', '=', $id)->where('type','=',4)->select('reg_no','fence_ids')->get();
    foreach ($buses as $key => $bus) {
      $fenceIds = $bus->fence_ids;
      if(sizeof($fenceIds) == 2){
        $startFence = Fence::find($fenceIds[0]);
        $destFence  = Fence::find($fenceIds[1]);
        $bus->setAttribute('start', $startFence->name);
        $bus->setAttribute('startId',$startFence->id);
        $bus->setAttribute('dest', $destFence->name);
        $bus->setAttribute('destId', $destFence->id);
      }
      else if(sizeof($fenceIds) == 0){
        $bus->setAttribute('start', '--');
        $bus->setAttribute('startId', null);
        $bus->setAttribute('dest', '--');
        $bus->setAttribute('destId', null);
      }
      else{
        $bus->setAttribute('start', sizeof($fenceIds).' GeoFence found');
        $bus->setAttribute('startId', null);
        $bus->setAttribute('dest', '--');
        $bus->setAttribute('destId', null);
      }

    }
    return response()->json($buses);
  }

  public function save(Request $request){
    $route = $request->all();
    $start = $route['start'];
    $dest = $route['dest'];
    $routename = $route['routename'];
    $id = $route['id'];

    $this->repository->skipPresenter();

    $car = Car::find($id);
    $fence = $this->repository->save($car, collect($start));

    if ( ! is_null($fence)) {
        event(new FenceCreated($car, $fence));

        $is_attached = isset($car->fence_ids) && in_array($fence->id, $car->fence_ids ?: []);

      /*  return response()->json([
            'attached' => $is_attached,
            'message' => 'New Geofence Saved',
        ]);*/
    }

    $fence = $this->repository->save($car, collect($dest));
    if ( ! is_null($fence)) {
        event(new FenceCreated($car, $fence));

        $is_attached = isset($car->fence_ids) && in_array($fence->id, $car->fence_ids ?: []);

        return response()->json([
            'attached' => $is_attached,
            'message' => 'New Geofence Saved',
        ]);
    }

    return response()->json('Geofence Create Failed');
  }

  public function delete(Request $request){
    $data = $request->all();
    $id = $data[0];
    $startId = $data[1];
    $destId = $data[2];
    $this->repository->skipPresenter();

    $car = Car::find($id);
    $fence = $this->repository->find($startId);

    if ( ! is_null($fence) && ! is_null($car)) {
      // TODO: delete fence from db
        event(new FenceDeleted($car, $fence));
    }


    $fence = $this->repository->find($destId);
    if ( ! is_null($fence) && ! is_null($car)) {
        event(new FenceDeleted($car, $fence));
        return response()->json('Geofence History Deleted');
    }

    return response()->json('Item Not Found');
  }
}
