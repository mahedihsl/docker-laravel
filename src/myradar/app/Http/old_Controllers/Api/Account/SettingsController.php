<?php

namespace App\Http\Controllers\Api\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Contract\Repositories\SettingRepository;
use App\Presenters\SettingPresenter;
use App\Criteria\UserIdCriteria;
use App\Criteria\UserNotTypeCriteria;
use App\Entities\User;
use App\Entities\Setting;
use App\Jobs\PushNotificationJob;
use App\Jobs\SinglePushJob;
use Illuminate\Support\Collection;

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

    public function view(Request $request, $id)
    {
        $model = $this->repository
                    ->pushCriteria(new UserIdCriteria($id))
                    ->first();
        if (is_null($model)) {
            $model = $this->repository->save(User::find($id));
        }

        return response()->ok($model);
    }

    public function change(Request $request)
    {
        return $this->update(User::find($request->get('user_id')), $request->all());
    }

    public function status(Request $request)
    {
        return response()->ok(
            $this->repository
                ->pushCriteria(new UserIdCriteria($this->getApiUser()->id))
                    ->first());
    }

    public function toggle(Request $request)
    {
        return $this->update($request->user('api'), $request->all());
    }

    private function update($user, $data)
    {
        $setting = $this->repository->pushCriteria(new UserIdCriteria($user->id))->first();

        if (is_null($setting)) {
            $setting = $this->repository->save($user);
        }

        $this->repository->change($setting->id, collect($data));

        return response()->ok();
    }

    public function test(Request $request)
    {
        // $data = collect([
        //     'title' => 'Hello From myRadar',
        //     'body' => 'We are testing your notification',
        //     'type' => 8,
        // ]);
        // $job = new SinglePushJob('5b3ddccd88d0a4528a7d5e9e', $data);
        // dispatch($job);

        // $ids = User::where('type', 4)->get()->map(function($u) {return $u->id;});
        // $temp = collect();
        // foreach ($ids as $id) {
        //     if (Setting::where('user_id', $id)->count() > 1) {
        //         $temp->push($id);
        //     }
        // }

        $query = [ 'device_id' => ['$eq' => '5ce0ef7cb5f41d338a7aa7db'] ];
		$options = [
			// 'skip' => ($curr_page - 1) * $per_page,
			'limit' => 80,
			'sort' => ['_id' => -1],
			'projection' => [
				'loop_count' => true,
				'es' => true,
			]
		];
		$items = \App\Entities\Health::raw(function($collection) use ($query, $options) {
			return $collection->find($query, $options);
		});


        return response()->ok([
            'count' => $items->count()
        ]);
    }
}
