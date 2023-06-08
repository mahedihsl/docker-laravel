<?php

namespace App\Http\Controllers\Fence;

use App\Contract\Repositories\GeofenceRepository;
use App\Entities\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Presenters\GeofencePresenter;

class LibraryController extends Controller
{
  private $repository;

  public function __construct(GeofenceRepository $repository) {
    $this->repository = $repository;    
  }

  public function index(Request $request)
  {
    $customerName = '';
    // if ($id != \Auth::user()->id) {
    //   $customerName = User::find($id)->name;
    // }
    return view('fence.library')->with([
      'customer_id' => 0,
      'customer_name' => $customerName,
    ]);
  }

  public function save(Request $request)
  {
    $model = $this->repository->save(collect($request->all()), $this->getWebUser());
    return response()->json([
      'status' => 1,
      'id' => $model->id,
    ]);
  }

  public function fetch(Request $request)
  {
    $geofences = $this->repository
                  ->setPresenter(GeofencePresenter::class)
                  ->ofUser($this->getWebUser()->id);
    return response()->json($geofences);
  }

  public function subscribe(Request $request)
  {
    $model = $this->repository->find($request->get('geofence_id'));
    $model->push('cars', [
      'id' => $request->get('car_id'),
      'reg_no' => $request->get('reg_no'),
    ], true);
    return response()->ok();
  }

  public function unsubscribe(Request $request)
  {
    $model = $this->repository->find($request->get('geofence_id'));
    $model->pull('cars', [
      'id' => $request->get('car_id'),
      'reg_no' => $request->get('reg_no'),
    ]);
    return response()->ok();
  }
}