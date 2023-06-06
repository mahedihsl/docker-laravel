<?php

namespace App\Http\Controllers\Device;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\PerformanceRepository;
use App\Criteria\ExactDateCriteria;
use App\Entities\Device;
use Carbon\Carbon;

class PerformanceController extends Controller
{
    /**
     * @var PerformanceRepository
     */
    private $repository;

    public function __construct(PerformanceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        return view('device.performance')->with([
            'day' => $request->get('day', '0'),
        ]);
    }

    public function stats(Request $request)
    {
        $day = intval($request->get('day'));
        $models = $this->repository
                        ->skipPresenter()
                        ->pushCriteria(new ExactDateCriteria(Carbon::today()->subDays($day)))
                        ->all();
        $ret = collect();
        foreach (config('device.health') as $key => $limit) {
            $count = $models->sum(function($item) use ($limit) {
                return intval($item->deviation >= $limit[0] && $item->deviation < $limit[1]);
            });
            $ret->put($key, $count);
        }
        return response()->json($ret);
    }

    public function items(Request $request)
    {
        $day = intval($request->get('day'));
        $models = $this->repository
                        ->pushCriteria(new ExactDateCriteria(Carbon::today()->subDays($day)))
                        ->all();

        $tag = $request->get('tag');
        $limit = config("device.health.{$tag}");
        $models = collect($models['data'])->filter(function($item) use ($limit) {
            return $item['deviation'] >= $limit[0] && $item['deviation'] < $limit[1];
        })
        ->values();

        return response()->json($models);
    }

	public function unhealthy(Request $request)
	{
		$items = Device::where('healthy.count', '>=', 5)
					->get()
					->filter(function($d) {
						return ! (is_null($d->car_id) || $d->user_id == '5b557d33fbe09d45b3017252');
					})
					->values()
					->map(function($device) {
						return [
							'com_id' => $device->com_id,
							'version' => $device->version,
							'last_pulse' => $device->last_pulse_label,
							'count' => $device->healthy['count'],
							'on_count' => $device->healthy['on_count'],
							'off_count' => $device->healthy['off_count'],
							'target' => route('manage.customer', [
								'id' => $device->user_id,
								'tab' => 'vehicles',
								'target' => $device->car_id,
							]),
						];
					});

		return view('device.unhealthy')->with([
			'items' => $items,
		]);
	}
}
