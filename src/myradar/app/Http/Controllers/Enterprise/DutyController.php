<?php

namespace App\Http\Controllers\Enterprise;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\DutyHourRepository;
use App\Criteria\CarIdCriteria;
use App\Criteria\DateRangeCriteria;
use App\Criteria\OrderByWhenCriteria;
use App\Entities\User;
use App\Entities\Car;
use Carbon\Carbon;
use Excel;

class DutyController extends Controller
{
    /**
     * @var DutyHourRepository
     */
    private $repository;

    public function __construct(DutyHourRepository $repository)
    {
        $this->repository = $repository;
    }

    public function show(Request $request)
    {
        return view('enterprise.duty')->with([
            'userId' => $request->user()->id,
            'month' => Carbon::today()->format('n'),
            'year' => Carbon::today()->format('Y'),
        ]);
    }

    public function sum(Request $request, $id)
    {
        $year = intval($request->get('year'));
        $month = intval($request->get('month'));

        $from = Carbon::today()->setDate($year, $month, 1);
        $to = $from->copy()->addMonth()->subDay();

        $this->repository->pushCriteria(new DateRangeCriteria($from, $to));
        $this->repository->pushCriteria(new CarIdCriteria($id));

        $duration = $this->repository->all()->sum(function($v) {
            return $v->duration;
        });

        return response()->json([
            'time' => intval($duration / 60),
            'month' => $from->format('F'),
        ]);
    }

    public function report(Request $request, $id)
    {
        $year = intval($request->get('year'));
        $month = intval($request->get('month'));

        $from = Carbon::today()->setDate($year, $month, 1);
        $to = $from->copy()->addMonth()->subDay();

        $records = $this->repository
                        ->pushCriteria(new CarIdCriteria($id))
                        ->pushCriteria(new DateRangeCriteria($from, $to))
                        ->all()
                        ->map(function($v) {
                            return [
                                'day' => $v->when->format('j'),
                                'val' => round($v->duration / 60, 1),
                            ];
                        });

        return response()->json($records);
    }

    public function export_v2(Request $request)
    {
        $id = $request->get('user_id');
        $year = intval($request->get('year'));
        $month = intval($request->get('month'));

        $from = Carbon::createFromDate($year, $month, 0);
        $to = $from->copy()->addMonth()->subDay();

        $cars = Car::where('user_id', $id)
                    ->orWhere('shared_with', 'all', [$id])
                    ->get(['_id'])
                    ->map(function($item) {return $item->id;})
                    ->toArray();

        $records = $this->repository
                        ->pushCriteria(new CarIdCriteria($cars))
                        ->pushCriteria(new DateRangeCriteria($from, $to))
                        ->pushCriteria(new OrderByWhenCriteria())
                        ->with(['car'])
                        ->all()
                        ->map(function($v) {
                            return [
                                'car' => $v->car->reg_no,
                                'day' => $v->when->format('j M Y'),
                                'val' => number_format($v->duration / 60, 1),
                                'from' => $v->start_format,
                                'to' => $v->finish_format,
                            ];
                        });


        $cars = $records->unique('car')
                    ->map(function($item) {
                        return $item['car'];
                    })->values();
        Excel::create('DutyHourReport', function ($excel) use ($cars, $records, $from, $to) {
            $excel->sheet('data', function ($sheet) use ($cars, $records, $from, $to) {
                $data = $cars->transform(function($car) use ($records, $from, $to) {

                    $filter = $records->filter(function($item) use ($car) {
                        return $item['car'] == $car;
                    })
                    ->sortBy('day')
                    ->values();

                    $date = $from->copy();
                    $ret = collect(['Reg. No.' => $car]);
                    while ($date->addDay()->lte($to)) {
                        $temp = $filter->first(function($v) use ($date) {
                            return $v['day'] == intval($date->format('j'));
                        });
                        $val = is_null($temp) ? '--' : "{$temp['val']} ({$temp['from']} - {$temp['to']})";
                        $ret->put($date->format('j M'), $val);
                    }

                    return $ret->toArray();
                });

                $sheet->fromArray($data->toArray(), null, 'A1', false, true);
            });
        })->download('xls');

        return redirect()->back();
    }

    public function export(Request $request)
    {
      $id = $request->get('user_id');

      $user = User::find($id);
      //$cars = $user->shared_cars;
      $cars = Car::where('user_id', $id)
                  ->orWhere('shared_with', 'all', [$id])
                  ->get(['_id'])
                  ->map(function($item) {return $item->id;})
                  ->toArray();
      $records = [];

      $wholedata = collect();
      $month = $request->get('month');
      $year = $request->get('year');

      $from = Carbon::today()->setDate($year, $month, 1);
      $to = $from->copy()->addMonth()->subDay();



      foreach ($cars as $key => $car) {
        $data = collect();
        $records[$key] = $this->repository
                              ->pushCriteria(new CarIdCriteria($car))
                              ->pushCriteria(new DateRangeCriteria($from, $to))
                              ->all()
                              ->map(function($v) {
                                  return [
                                      'day' => $v->when->format('j'),
                                      'val' => [
                                                  'dur'=>number_format($v->duration / 60, 1),
                                                  'from' => $v->start_format,
                                                  'to' => $v->finish_format,
                                               ],
                                  ];
                              });
        $carbody = Car::find($car);
        $reg_no = $carbody->reg_no;
        $records[$key]->put('reg_no', $reg_no);
        $temp = $records[$key];
        //return response()->json($temp);
      //  dd($temp);
        $data->put('reg_no', $reg_no);
        $i = 0; $ind=0;
        for($i=0; $i<sizeof($temp)-2; $i++){
          if (intval($temp[$i]['day']) == intval($temp[$i+1]['day'])-1) {

            $data->put(intval($temp[$i]['day']),$temp[$i]['val']);
          }
          else {
            $data->put(intval($temp[$i]['day']),$temp[$i]['val']);
            $ind = intval($temp[$i]['day'])+1;
            while ($ind < intval($temp[$i+1]['day'])) {
              $data->put($ind++,0.0);
            }
          }
        }
        if(sizeof($temp)>1){
          $data->put(intval($temp[$i]['day']),$temp[$i]['val']);
        }

        $index=0;
        if(sizeof($temp)>1){
          $index = max(intval($temp[$i]['day']), $ind);
        }

        while($index <= 31)
        {
          $data->put(++$index,0.0);
        }
        //dd($data);
        //return response()->json($data->get('reg_no'));

        $wholedata->push($data);
        $this->repository->popCriteria(new CarIdCriteria($car));
      }

      //dd($wholedata);
    //  return response()->json($wholedata);

      $mon = $from->format('M');
      $month =$from->format('F');
      Excel::create('DutyHours of '.$month, function ($excel) use ($wholedata, $mon) {
          $excel->sheet('wholedata', function ($sheet) use ($wholedata, $mon) {
              $wholedata->transform(function ($item) use ($mon) {

                $temp = [];
                $temp['reg_no'] = $item->get('reg_no');

                for($i =1; $i<=31; $i++)
                {
                  $temp[$i.'-'.$mon] = is_null($item->get(strval($i))['dur']) ? "--" : "{$item->get(strval($i))['dur']} ({$item->get(strval($i))['from']} - {$item->get(strval($i))['to']})";
                }
                return $temp;
              });

              $sheet->fromArray($wholedata->toArray(), null, 'A1', false, true);
              //$sheet->setAutoSize(false);
          });
      })->download('xls');

      return redirect()->back();
    }
}
