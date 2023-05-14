<?php

namespace App\Http\Controllers\Enterprise;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\DrivingHourRepository;
use App\Criteria\CarIdCriteria;
use App\Criteria\DateRangeCriteria;
use App\Transformers\DrivingExportTransformer;
use App\Entities\User;
use App\Entities\Car;
use Carbon\Carbon;

use Excel;

class DrivingController extends Controller
{
    /**
     * @var DrivingHourRepository
     */
    private $repository;

    public function __construct(DrivingHourRepository $repository)
    {
        $this->repository = $repository;
    }

    public function show(Request $request)
    {
        return view('enterprise.driving')->with([
            'userId' => $request->user()->id,
        ]);
    }

    public function sum(Request $request, $id)
    {
        $year = intval($request->get('year'));
        $month = intval($request->get('month'));

        $from = Carbon::today()->setDate($year, $month, 1);
        $to = $from->copy()->addMonth()->subDay();

        $duration = $this->repository
                        ->pushCriteria(new DateRangeCriteria($from, $to))
                        ->pushCriteria(new CarIdCriteria($id))
                        ->all()
                        ->sum(function($v) {
                            return $v->duration;
                        });

        return response()->ok([
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

        return response()->ok($records);
    }

    public function export(Request $request)
    {
      $id = $request->get('id');

      $user = User::find($id);
      $cars = $user->shared_cars;
      $records = [];

      $wholedata = collect();
      $month = $request->get('m');
      $year = $request->get('y');

      $from = Carbon::today()->setDate($year, $month+1, 1);
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
                                      'val' => round($v->duration / 60, 1),
                                  ];
                              });
        $carbody = Car::find($car);
        $reg_no = $carbody->reg_no;
        $records[$key]->put('reg_no', $reg_no);



        $temp = $records[$key];
        //return response()->ok($temp);
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
        //return response()->ok($data->get('reg_no'));
        $wholedata->push($data);
        $this->repository->popCriteria(new CarIdCriteria($car));
      }


    //  return response()->ok($wholedata);

      $mon = $from->format('M');
      $month =$from->format('F');

      Excel::create('DrivingHours of '.$month, function ($excel) use ($wholedata, $mon) {
          $excel->sheet('wholedata', function ($sheet) use ($wholedata, $mon) {
              $wholedata->transform(function ($item) use($mon){

                  $temp = [];
                  $temp['reg_no'] = $item->get('reg_no');

                  for($i =1; $i<=31; $i++)
                  {
                    $temp[$i.'-'.$mon] = round($item->get(strval($i)));
                  }
                  return $temp;
              });

              $sheet->fromArray($wholedata->toArray(), null, 'A1', false, true);
              $sheet->setAutoSize(false);
          });
      })->download('xls');

      return redirect()->back();
    }
}
