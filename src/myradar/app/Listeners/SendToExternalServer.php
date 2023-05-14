<?php

namespace App\Listeners;

use App\Events\ExternalDeviceDataReceived;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Carbon\Carbon;
use App\Entities\Device;
use App\Entities\Mileage;
use App\Criteria\DeviceIdCriteria;
use App\Criteria\ExactDateCriteria;
use App\Contract\Repositories\MileageRepository;
use App\Service\DirectionService;
use \Datetime;

class SendToExternalServer
{
    /**
     * @var MileageRepository
     */
    private $repository;

    function __construct()
    {
        $this->repository = resolve(MileageRepository::class);
    }

    /**
     * Handle the event.
     *
     * @param  ExternalDeviceDataReceived  $event
     * @return void
     */
    public function handle(ExternalDeviceDataReceived $event)
    {
		$data = [
			'id' => intval($event->data->get('ss')),
			'name' => $event->device->car->reg_no,
			'status' => 'online',
			"attributes" => [
				'ignition' => boolval($event->data->get('es') == 1),
				'distance' => $this->mileage($event->device->id),
				'totalDistance' => $this->totalMileage($event->device->id),
			],
			'latitude' => $this->getPos($event->data->get('lt', null), 0),
			'longitude' => $this->getPos($event->data->get('lt', null), 1),
			'altitude' => 0,
			'speed' => doubleval($event->data->get('vl')),
			'course' => intval($event->device->bearing),
			// 'lastUpdate' => "2020-01-14T10:36:37.627+0000",
			'lastUpdate' => Carbon::now()->format(DateTime::ISO8601),
		];
		try {
			$client = new Client([
				'headers' => [
					'Authorization' => 'Basic Hx30anDJsagaL6ZiWZJVoiPsx4w9Hym'
					// 'AccessToken' => 'Hx30anDJsagaL6ZiWZJVoiPsx4w9Hym'
				]
			]);
			// $endpoint = "https://sandbox.jatri.co/iot-api/my-radar/update-location";
			$endpoint = "https://api.jslglobal.co/iot-api/my-radar/update-location";
			// $endpoint = "http://34.223.233.165:10002/";
			// $endpoint = "http://45.64.135.28/api/test/device/receive";
			$response = $client->request('POST', $endpoint, [
				'json' => $data,
			]);

			$code = $response->getStatusCode();
			Log::info('external server data sent: ', [
				'id' => $data['id'],
				'code' => strval($code),
				'data' => $response->getBody()->read(1024),
			]);
		} catch (\Exception $e) {
			Log::info('external server data send error: ', [
				'message' => $e->getMessage(),
				'car' => $data['name'],
			]);
		}
	}
	
	public function mileage($device_id)
	{
		$date = Carbon::now()->subHours(3);
		$date->hour = 0;
		$date->minute = 0;
		$date->second = 0;

		$model = $this->repository
                    ->skipPresenter()
                    ->pushCriteria(new DeviceIdCriteria($device_id))
                    ->pushCriteria(new ExactDateCriteria($date))
					->first();
		
		try {
			return $model->value;
		} catch (\Exception $e) {
			return 0;
		}
	}

	public function totalMileage($device_id)
	{
		return Mileage::raw(function($collection) use ($device_id) {
			return $collection->aggregate([[
					'$match' => [
						'device_id' => $device_id
					]
				], [
					'$group' => [
						'_id' => null,
						'total' => [
							'$sum' => '$value'
						]
					]
				]
			]);
		})->first()->total;
	}

	public function getPos($val, $i)
	{
		if ( ! $val) {
			return 0.00;
		}

		try {
			return doubleval(explode(",", $val)[$i]);
		} catch (\Exception $e) {
			return 0.00;
		}
	}
}
