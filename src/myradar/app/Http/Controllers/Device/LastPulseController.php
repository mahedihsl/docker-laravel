<?php

namespace App\Http\Controllers\Device;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\PerformanceRepository;
use App\Entities\Device;
use App\Criteria\ExactDateCriteria;
use Carbon\Carbon;

class LastPulseController extends Controller
{
    /**
     * @var PerformanceRepository
     */
    private $repository;

    public function __construct()
    {

    }

    public function index(Request $request)
    {
        return view('device.last_pulse')->with([
           'day' => $request->get('day', '0'),
        ]);
    }

    public function stats(Request $request)
    {
        $day = intval($request->get('day'));
        $ret = collect();

        if($day == '0'){
          $versionLow = '3.7.5';
          $versionHigh = '9999999999.9.9';
          foreach (config('device.lastPulse') as $key => $value) {
            $deviceList = $this->getDeviceList($versionLow, $versionHigh, $value[0], $value[1]);
            $ret->put($key, $deviceList->count());
          }
        }else{
          $versionLow = '1.1.1';
          $versionHigh = '3.7.4';
          foreach (config('device.lastPulse') as $key => $value) {
            $deviceList = $this->getDeviceList($versionLow, $versionHigh, $value[0], $value[1]);
            $ret->put($key, $deviceList->count());
          }
        }

        return response()->ok($ret);
    }

    public function getDeviceList($versionLow, $versionHigh, $timeLow, $timeHigh)
    {
      $low_time = Carbon::now()->subMinutes($timeLow);
      $high_time = new Carbon('first day of January 2008', 'America/Vancouver');
      if($timeHigh){
        $high_time = Carbon::now()->subMinutes($timeHigh);
      }

      $deviceList = Device::where('last_pulse', '<=', $low_time)
                          ->where('last_pulse', '>', $high_time)
                          ->where('version', '>=', $versionLow)
                          ->where('version', '<=', $versionHigh)
                          ->whereNotNull('car_id')
                          ->whereNotNull('user_id')
						  ->whereNotIn('user_id', [
							  '5b557d33fbe09d45b3017252',
							  '59647a2ee6179b1b7159f314',
							  '59803f60dac177031948e2d2'
						  ])
						  ->with(['car'])
                          ->get();
      return $deviceList;
    }

    public function items(Request $request)
    {
      $day = intval($request->get('day'));
      $tag = $request->get('tag');
      $deviceList = collect();

      if($day == '0'){
          $versionLow = '3.7.5';
          $versionHigh = '9999999999.9.9';
          $value = config("device.lastPulse.{$tag}");
          $deviceList = $this->getDeviceList($versionLow, $versionHigh, $value[0], $value[1]);
      }else{
        $versionLow = '1.1.1';
        $versionHigh = '3.7.4';
        $value = config("device.lastPulse.{$tag}");
        $deviceList = $this->getDeviceList($versionLow, $versionHigh, $value[0], $value[1]);
      }
      $ret = collect();
      $ret = $this->transformList($deviceList);

      return response()->ok($ret);
    }

    public function transformList($deviceList)
    {
      $result = collect();

      foreach ($deviceList as $key => $device) {
		  $comp = $device->car->getLatestComplain();
        $result[$key] = [
			'id' => $device->id,
			'com_id' => $device->com_id,
            'phone' => $device->phone,
            'version' => $device->version,
            'last_pulse' => $device->last_pulse_label,
            'target' => route('manage.customer', [
                'id' => $device->user_id,
                'tab' => 'vehicles',
                'target' => $device->car_id,
            ]),
			'complain' => is_null($comp) ? 'None' : $comp->status,
			'reset_calls' => $device->reset_calls,
			'reset_attempts' => $device->reset_attempts,
		];
	}

      return $result;
    }

	public function update(Request $request)
	{
		$dev = Device::find($request->get('id'));

		if ( ! is_null($dev)) {
			if ($request->get('ring') == 1) {
				$calls = $dev->reset_calls;
				$dev->reset_calls = $calls + 1;
			} else {
				$attempts = $dev->reset_attempts;
				$dev->reset_attempts = $attempts + 1;
			}

			$dev->save();

			return response()->ok([
				'reset_calls' => $dev->reset_calls,
				'reset_attempts' => $dev->reset_attempts,
			]);
		}

		return response()->error();
	}
}
