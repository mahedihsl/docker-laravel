<?php

namespace App\Http\Controllers\Fence;

use App\Contract\Repositories\GeofenceRepository;
use App\Entities\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Presenters\GeofencePresenter;

use App\Service\Microservice\ServiceException;
use App\Service\Microservice\GeofenceMicroservice;

class AreaController extends Controller
{
  private $repository;
  private $geofenceService;

  public function __construct(GeofenceRepository $repository) {
    $this->repository = $repository;
    $this->geofenceService = new GeofenceMicroservice();
  }

  public function index(Request $request)
  {
    $customer = User::find($request->get('user_id'));
    return view('fence.polygon')->with([
      'customer' => $customer,
    ]);
  }

  public function library(Request $request)
  {
    return view('fence.library');
  }

  public function save(Request $request)
  {
    $user = User::find($request->get('user_id'));
    $model = $this->repository->save(collect($request->all()), $user);
    return response()->json([
      'status' => 1,
      'id' => $model->id,
    ]);
  }

  public function fetch(Request $request)
  {
    $geofences = $this->repository
                  ->setPresenter(GeofencePresenter::class)
                  ->ofUser($request->get('user_id'));
    
    return response()->json($geofences);
  }

  public function templates(Request $request)
  {
    $geofences = $this->repository
                  ->setPresenter(GeofencePresenter::class)
                  ->templates();
    
    return response()->json($geofences);
  }

  public function attachTemplate(Request $request)
  {
    $userId = $request->get('user_id');
    $templateId = $request->get('template_id');

    $geofence = $this->repository
                  ->setPresenter(GeofencePresenter::class)
                  ->attachTemplate($templateId, $userId);
    return response()->json($geofence);
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

  public function remove(Request $request)
  {
    try {
      $this->geofenceService->removeGeofence($request->get('id'));
      return response()->ok();
    } catch (ServiceException $e) {
      return response()->json(['message' => $e->getMessage()], 400);
    }
  }

  public function update(Request $request)
  {
    try {
      $this->geofenceService->updateGeofence($request->all());
      return response()->ok();
    } catch (ServiceException $e) {
      return response()->json(['message' => $e->getMessage()], 400);
    }
  }

  public function syncSubscriptions(Request $request)
  {
    try {
      $this->geofenceService->syncSubscriptions(
        $request->get('geofence_id'),
        $request->get('car_ids')
      );
      return response()->ok();
    } catch (ServiceException $e) {
      return response()->json(['message' => $e->getMessage()], 400);
    }
  }

  public function fetchSubscriptions(Request $request)
  {
    try {
      $subscriptions = $this->geofenceService->fetchSubscriptions(
        $request->get('geofence_id')
      );
      return response()->json($subscriptions);
    } catch (ServiceException $e) {
      return response()->json(['message' => $e->getMessage()], 400);
    }
  }
}