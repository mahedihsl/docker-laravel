<?php

namespace App\Listeners;

use App\Events\DeviceHealthReceived;
use App\Entities\Health;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckFrequestReset
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  DeviceHealthReceived  $event
     * @return void
     */
	public function handle(DeviceHealthReceived $event)
	{
		// Dont calculate here
		return;


		$query = [ 'device_id' => ['$eq' => $event->device->id] ];
		$options = [
			// 'skip' => ($curr_page - 1) * $per_page,
			'limit' => 80,
			'sort' => ['_id' => -1],
			'projection' => [
				'loop_count' => true,
				'es' => true,
			]
		];
		$items = Health::raw(function($collection) use ($query, $options) {
			return $collection->find($query, $options);
		})
		->filter(function($v) {
			return $v->loop_count == 1;
		});
		// $items = Health::where('device_id', $event->device->id)
		// 			->orderBy('_id', 'desc')
		// 			->limit(80)
		// 			->get(['loop_count', 'es'])
		// 			->filter(function($v) {
		// 				return $v->loop_count == 1;
		// 			});

		$event->device->update([
			'healthy' => [
				'count' => $items->count(),
				'on_count' => $items->filter(function($v) {return $v['es'] == 1;})->count(),
				'off_count' => $items->filter(function($v) {return $v['es'] == 0;})->count(),
			]
		]);
	}
}
