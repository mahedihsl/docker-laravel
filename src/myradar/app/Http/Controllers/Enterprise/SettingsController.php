<?php

namespace App\Http\Controllers\Enterprise;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Contract\Repositories\SettingRepository;
use App\Presenters\SettingPresenter;
use App\Criteria\UserIdCriteria;
use App\Criteria\CarIdCriteria;
use App\Entities\User;
use App\Entities\Car;
use App\Entities\Setting;
use App\Jobs\PushNotificationJob;

class SettingsController extends Controller
{
      /**
       * @var SettingRepository
       */
      private $repository;
      public function __construct(SettingRepository $repository)
      {
          $this->repository = $repository;
      }

      public function show(Request $request)
      {
          return view('enterprise.settings')->with([
              'userId' => $request->user()->id,
          ]);
      }

      public function view(Request $request, $userId, $carId)
      {
          $model = $this->repository
                        ->pushCriteria(new UserIdCriteria($userId))
                        ->pushCriteria(new CarIdCriteria($carId))
                        ->first();
          if (is_null($model)) {
              $model = $this->repository->enterSave(User::find($userId), Car::find($carId));
          }

          return response()->json($model);
      }

      public function change(Request $request)
      {
          return $this->update(User::find($request->get('user_id')), Car::find($request->get('car_id')), $request->all());
      }

      private function update($user, $car, $data)
      {
          $setting = $this->repository->pushCriteria(new UserIdCriteria($user->id))
                                      ->pushCriteria(new CarIdCriteria($car->id))
                                      ->first();
            if (is_null($setting)) {
                $setting = $this->repository->enterSave($user, $car);
            }

            $this->repository->change($setting->id, collect($data));

            return response()->json();
      }
}
