<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\Position;
use App\Entities\Activation;
use App\Entities\User;
use App\Entities\Car;
use App\Entities\Device;
use App\Entities\Event;
use App\Entities\Complain;
use App\Entities\ExecTime;
use App\Jobs\DemoUserDataJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use App\Transformers\PositionTransformer;
use Carbon\Carbon;

class DatabaseTestController extends Controller
{
    public function lastPost(Request $request)
    {
        $devices = Device::all();
        $count = 0;
        $transformer = new PositionTransformer();
        for ($i = 0; $i < $devices->count(); $i++) { 
            $lastPos = $devices->get($i)->positions()->orderBy('when', 'desc')->first();
            if ( ! is_null($lastPos)) {
                $devices->get($i)->update([
                    'meta.pos' => $transformer->transform($lastPos),
                    'meta.mil_pos' => $transformer->transform($lastPos),
                ]);
                $count++;
            }
        }
        return $count;
    }

	public function remove(Request $request)
	{
		$n = User::count();

		return $n;
    }
    
    public function throttle(Request $request) {
        $time = Carbon::now()->subMinutes(1);
        $n = ExecTime::where('created_at', '>', $time)->count();
        return response()->json([
            'api_hit' => $n
        ]);
    }

    public function redis(Request $request)
    {
        return [
            'value' => Redis::command('get', ['bkash:checkout_iframe:refresh_token'])
        ];
    }

    public function restore(Request $request)
    {
        // User::create([
        //     'name' => 'Admin',
        //     'email' => 'admin@myradar.com.bd',
        //     'password' => bcrypt('Pixel@123456'),
        //     'type' => 1,
        // ]);
        // User::create([
        //     'name' => 'Customer Care',
        //     'email' => 'cc@myradar.com.bd',
        //     'password' => bcrypt('cc@myradar2020'),
        //     'type' => 2,
        // ]);
        // User::create([
        //     'name' => 'Eng. & Ops',
        //     'email' => 'ops@myradar.com.bd',
        //     'password' => bcrypt('ops@myradar2020'),
        //     'type' => 3,
        // ]);
        // $data = $request->get('data');
        // for ($i=0; $i < count($data); $i++) {
        //     $doc = $data[$i];
        //     $phone = $doc['Phone'];
        //     $carno = $doc['Car No.'];
        //     $comid = $doc['Com. ID'];

            // $user = User::where('phone', $phone)->first();

            // $car = Car::where('reg_no', $carno)->first();
            // if (!$car) {
            //     $car = Car::create([
            //         'reg_no' => $carno,
            //         'user_id' => $user->id,
            //     ]);
            // }

            // if (!is_null($car) && $comid != 'N/A') {
            //     $device = Device::create([
            //         'com_id' => intval($comid),
            //         'car_id' => $car->id,
            //         'user_id' => $car->user->id,
            //     ]);
            // }
            // if (!$user) {
            //     $user = User::create([
            //         'name' => $doc['User'],
            //         'phone' => $phone,
            //         'password' => bcrypt($phone),
            //         'api_token' => str_random(60),
            //         'type' => 4,
            //         'customer_type' => 1,
            //         'enabled' => $doc['Enabled'] == 'Yes' ? 1 : 0,
            //         'status' => $doc['Status'] == 'Current' ? 1 : 0,
            //         'joined_at' => Carbon::createFromFormat('D, M j, Y g:i A', $doc['Date']),
            //     ]);
            // }
        // }
        return ['message' => 'Accounts Created'];
    }

    public function restore2(Request $request)
    {
        // $data = $request->get('data');
        // for ($i=0; $i < count($data); $i++) { 
        //     $doc = $data[$i];
        //     $phone = '0' . $doc['Mobile No'];
        //     $carno = $doc['Car No'];
        //     $comid = $doc['Com ID'];

        //     $user = User::where('phone', $phone)->first();
        //     if (!$user) {
        //         $user = User::create([
        //             'name' => $doc['Name'],
        //             'Phone' => $phone,
        //             'joined_at' => Carbon::createFromFormat("jS-F'y", $doc['Installation date line']),
        //             'password' => bcrypt($phone),
        //             'api_token' => str_random(60),
        //             'type' => 4,
        //             'customer_type' => 1,
        //             'enabled' => 1,
        //             'status' => 1,
        //         ]);
        //     }

        //     $car = Car::where('reg_no', $carno)->first();
        //     if (!$car) {
        //         $car = Car::create([
        //             'name' => $doc['Car Name'],
        //             'reg_no' => $carno,
        //             'user_id' => $user->id,
        //         ]);
        //     }

        //     $device = Device::create([
        //         'com_id' => $comid,
        //         'car_id' => $car->id,
        //         'user_id' => $user->id,
        //     ]);
        // }

        return 'ok';
    }

    public function restore3(Request $request)
    {
        $x = 0;
        $y = 0;
        $data = $request->get('data');
        foreach ($data as $doc) {
            $comid = $doc['Commercial_id'];
            $phone = $doc['Phone'];

            $device = Device::where('com_id', $comid)->first();
            if (is_null($device)) {
                $device = Device::create([
                    'com_id' => $comid,
                    'phone' => $phone,
                ]);
                $x++;
            } else {
                $device->update(['phone' => $phone]);
                $y++;
            }
        }
        return 'device phone number updated: ' . $x . '-' . $y;
    }

    public function demoUser(Request $request)
    {
        $device = Device::where('com_id', 22235)->first();
        $control_method = is_null($device->engine_control) ? Device::$ENGINE_CONTROL_LOCK : $device->engine_control;
        
        return response()->json([
            'com_id' => $device->com_id,
            'car_id' => $device->car_id,
            'controlled_state' => $device->lock_status,
            'control_method' => $control_method,
        ]);
    }

    public function demoPatch(Request $request)
    {
        $device = Device::where('com_id', 42002)->with(['car'])->first();
        // Event::where('type', 3)->take(15)->get()->each(function($event) use ($device) {
        //     Event::create([
        //         'title' => 'Alert for car: ' . $device->reg_no,
        //         'body' => $event->body,
        //         'type' => $event->type,
        //         'mode' => $event->mode,
        //         'meta' => $event->meta,
        //         'car_id' => $device->car_id,
        //         'user_id' => $device->user_id,
        //         'created_at' => $event->created_at,
        //         'updated_at' => $event->updated_at,
        //     ]);
        // });
        return $device;
    }

    public function patch(Request $request)
    {
        $c = 0;
        $missing = collect();

        // $activations = Activation::with(['car'])->get();
        // foreach ($activations as $model) {
        //     $model->update([
        //         'created_at' => $model->car->created_at
        //     ]);
        //     $c++;
        // }

        // $users = User::with(['cars'])->get();
        // foreach ($users as $user) {
        //     if ($user->cars->count() > 0) {
        //         $sorted = $user->cars->sortBy(function ($c) {
        //             return $c->created_at->timestamp;
        //         });
        //         if ($sorted->get(0)->created_at->timestamp < $user->created_at->timestamp) {
        //             // $user->update(['created_at' => $sorted->get(0)->created_at]);
        //             $c++;
        //         }
        //     }
        // }
        // Device::create([
        //     'com_id' => 17200,
        //     'phone' => '01907482393',
        // ]);
        // $data = $request->get('data');
        // $cars = Car::all();
        // $data = [
        //     [93885, '0358735077676962', '01958532574'],
        //     [67559, '0358735077688710', '01958532573'],
        //     [46767, '0358735077700606', '01958532572'],
        //     [10909, '0358735077678901', '01958532571'],
        //     [67010, '0358735077697265', '01958532570'],
        //     [76310, '0358735077704319', '01958532569'],
        // ];
        // foreach ($data as $row) {
        //     $device = Device::where('com_id', $row[0])->first();
        //     if ( ! is_null($device)) {
        //         $device->update([
        //             'imei' => $row[1],
        //             'phone' => $row[2],
        //             'version' => '0.0.1',
        //         ]);
        //         $c++;
        //     } else {
        //         Device::create([
        //             'com_id' => $row[0],
        //             'phone' => $row[2],
        //             'imei' => $row[1],
        //             'version' => '0.0.1',
        //         ]);
        //         $missing->push($row[0]);
        //     }
        // }
        // foreach ($data as $row) {
        //     $car = $cars->first(function($item) use ($row) {
        //         return $item->reg_no == trim($row['Car No.']);
        //     });
        //     if ( ! is_null($car)) {
        //         $time = Carbon::createFromFormat('M j, Y', $row['Date']);
        //         $time->hour = 10;
        //         $time->minute = 10;
        //         $time->second = 10;
        //         $car->update([ 'created_at' => $time, ]);
        //         $c++;
        //     } else {
        //         $missing->push($row['Car No.']);
        //     }
        // }
        // $data = [
        //     [62363, '0358735077685468'],
        //     [16624, '0358735077677382'],
        //     [76977, '0358735077704251'],
        //     [28193, '0358735077682069'],
        // ];
        // foreach ($data as $row) {
        //     $device = Device::where('com_id', $row[0])->first();
        //     $device->update(['imei' => $row[1]]);
        //     $c++;
        // }

        // $hours = 72;
        // foreach ($data as $row) {
        //     $car = $cars->first(function($v) use ($row) {
        //         return $v->reg_no == $row['Car'];
        //     });
        //     $comment = collect([
        //         $row['Comment #1'],
        //         $row['Comment #2'],
        //         $row['Comment #3'],
        //     ])
        //     ->filter(function($c) { return $c != '--'; })
        //     ->map(function($c) { return ['body' => $c, 'who' => 'unknown', 'when' => 0]; })
        //     ->toArray();
        //     $when = Carbon::now()->subHours($hours);
        //     Complain::create([
        //         'car_id' => is_null($car) ? null : $car->id,
        //         'status' => $row['Status'],
        //         'token' => $row['Token'],
        //         'reg_no' => $row['Car'],
        //         'emp' => $row['Creator'],
        //         'responsible' => array_search($row['Responsible'], ['N/A', 'CCD', 'Eng - Ops']),
        //         'when' => $when,
        //         'created_at' => $when,
        //         'updated_at' => $when,
        //         'when' => $when,
        //         'type' => $row['Type'],
        //         'title' => '(Title Not Available)',
        //         'body' => $row['Description'],
        //         'comment' => $comment,
        //     ]);
        //     $c++;
        //     $hours++;
        // }
        // $data = [
        //     ['com_id' => 50809, 'phone' => '01958532646', 'car_id' => null, 'user_id' => null],
        //     ['com_id' => 22155, 'phone' => '01958532610', 'car_id' => null, 'user_id' => null],
        // ];
        // foreach ($data as $val) {
        //     Device::create($val);
        // }

        // $users = User::all();
        // foreach ($users as $user) {
        //     $car = $user->cars()->first();
        //     if (!is_null($car)) {
        //         $refno = str_replace('-', '', $car->reg_no);
        //         $user->update(['ref_no' => $refno]);
        //         $c++;
        //     }
        // }
        // foreach ($data as $row) {
        //     $carno = $row['Car No'];
        //     $car = Car::where('reg_no', $carno)->first();
        //     if (!is_null($car)) {
        //         $car->update([
        //             'bill' => 500,
        //             'services' => [1, 2, 4, 5, 6, 7],
        //         ]);
        //         $c++;
        //     } else {
        //         $missing->push($carno);
        //     }
        // }

        // $users = User::all();
        // foreach ($users as $user) {
        //     if (strlen($user->Phone)) {
        //         $user->update(['phone' => $user->Phone]);
        //         $user->unset('Phone');
        //         $c++;
        //     }
        // }

        return [
            'message' => 'Car service patched: ' . $c,
            'missing' => $missing,
        ];
    }
}
