<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Collection;
use App\Contract\Repositories\UserRepository;
use App\Consumer\LatLngConsumer;
use App\Consumer\GeoFenceConsumer;
use App\Service\DirectionService;
use Carbon\Carbon;

class DemoUserDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
     public function handle()
     {
         $device = $this->getDemoDevice();

         $job = (new DemoUserDataJob())->delay(Carbon::now()->addSeconds(10));

         if ( ! $device->engine_status) {
             // dispatch($job);
             return;
         }

         $device->update([ 'last_pulse' => Carbon::now() ]);

         $list = collect($this->latLngArray());
         if ( ! $this->insertNextPos($device, $list)) {
             $this->consumePos($device, $list->first());
         }

         dispatch($job);
     }

     public function insertNextPos($device, $list)
     {
         //$fences = $device->car->fences;
         $last = $this->getLastPos($device);
         for ($i=0; $i < $list->count(); $i++) {
             $p = $list->get($i);
             if ($p[0] == $last['lat'] && $p[1] == $last['lng']) {
                 $next = ($i - 1 + $list->count()) % $list->count();
                 $this->consumePos($device, $list->get($next));
                 //$this->checkFenceViolation($device, $list->get($next), $fences);
                 return true;
             }
         }

         return false;
     }

     public function consumePos($device, $pos)
     {
         $consumer = new LatLngConsumer(implode(",", $pos));
         $consumer->consume($device);
     }

     public function checkFenceViolation($device, $pos, $fences)
     {
         $service = new DirectionService();
         foreach ($fences as $key => $fence) {
             $dist = $service->distance($pos[0], $pos[1], $fence->lat, $fence->lng);
             if ($dist < 200) {
                 $data = implode(",", [$fence->id, 1]);
                 $consumer = new GeoFenceConsumer($data);
                 $consumer->consume($device);
                 return;
             }
         }
     }

     public function getDemoUser()
     {
         return resolve(UserRepository::class)
                     ->scopeQuery(function($query) {
                         return $query->where('email', 'demo@myradar.com');
                     })
                     ->first();
     }

     public function getDemoDevice()
     {
         return $this->getDemoUser()->devices()->first();
     }

     public function getLastPos($device)
     {
         return $device->meta['pos'];
     }

     public function latLngArray()
     {
         $ret = [
             [23.850347, 90.408795],
             [23.849442, 90.409460],
             [23.848701, 90.410080],
             [23.847762, 90.410864],
             [23.846803, 90.411661],
             [23.845535, 90.412680],
             [23.844279, 90.413766],
             [23.842759, 90.414998],
             [23.841894, 90.415710],
             [23.841126, 90.416340],
             [23.839720, 90.417311],
             [23.838061, 90.418177],
             [23.836989, 90.418509],
             [23.835770, 90.418842],
             [23.833852, 90.419177],
             [23.831754, 90.419515],
             [23.830770, 90.419708],
             [23.827876, 90.420169],
             [23.826725, 90.420365],
             [23.825145, 90.420558],
             [23.823948, 90.420402],
             [23.821509, 90.418991],
             [23.819991, 90.416778],
             [23.819078, 90.415375],
             [23.817490, 90.412899],
             [23.816724, 90.410989],
             [23.816877, 90.408242],
             [23.816801, 90.406261],
             [23.814759, 90.404394],
             [23.811447, 90.403880],
             [23.806578, 90.403075],
             [23.802205, 90.402340],
             [23.798204, 90.401602],
             [23.798204, 90.401602],
             [23.794482, 90.400928],
             [23.794534, 90.400906],
             [23.795432, 90.400997],
             [23.796730, 90.401241],
             [23.798389, 90.401507],
             [23.800279, 90.401848],
             [23.801712, 90.402092],
             [23.803479, 90.402398],
             [23.805378, 90.402704],
             [23.807807, 90.403144],
             [23.810634, 90.403648],
             [23.813971, 90.404179],
             [23.815821, 90.404791],
             [23.816984, 90.406390],
             [23.816979, 90.408820],
             [23.816922, 90.411405],
             [23.818600, 90.414339],
             [23.820789, 90.417788],
             [23.821937, 90.419247],
             [23.823861, 90.420272],
             [23.827417, 90.420122],
             [23.829385, 90.419783],
             [23.831358, 90.419434],
             [23.833674, 90.419058],
             [23.835529, 90.418733],
             [23.838846, 90.417670],
             [23.842195, 90.415275],
             [23.845588, 90.412469],
             [23.849455, 90.409257],
         ];

         return array_reverse($ret);
     }
}
