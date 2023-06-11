<?php

namespace App\Http\Controllers\Account;

use App\Entities\Device;
use App\Entities\Recharge;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\Car;
//use Excel;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use App\Contract\Repositories\CarRepository;
use App\Generator\CarCriteriaGenerator;
use App\Transformers\CarExportTransformer;
use Maatwebsite\Excel\Facades\Excel;

class BillingController extends Controller
{
    /**
     * @var CarRepository
     */
    private $repository;

    public function __construct(CarRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $this->repository->skipPresenter();

        $factory = new CarCriteriaGenerator(collect($request->all()));
        foreach ($factory->all() as $item) {
            $this->repository->pushCriteria($item);
        }

        if ($request->get('type') == 'export') {
            $this->export($this->repository->all());
        }

        return view('car.billing')->with([
            'cars' => $this->repository->paginate(),
            'params' => $request->all(),
        ]);
    }

    public function export($data)
    {
        return Excel::download(function ($excel) use ($data) {
            $excel->sheet('data', function ($sheet) use ($data) {
                $data->transform(function ($car) {
                    $transformer = new CarExportTransformer();
                    return $transformer->transform($car);
                });
        
                $sheet->fromArray($data->toArray(), null, 'A1', false, true);
        
                $sheet->row(1, function ($row) {
                    $row->setFontWeight('bold');
                });
            });
        }, 'billing.xlsx');           
    }

    public function importExcel(Request $request)
    {
        //$sheetNames = [];
        if ($request->hasFile('import_file')) {
            $path = $request->file('import_file')->getRealPath();
            //$sheetNames = Excel::load($path)->getSheetNames();
            $data = Excel::load($path, function ($reader) {
            })->get();
            //return $data;
            $import_errors = [];
           $sucessfull_recharges = [];
            $timestamp =Carbon::now()->timestamp;

            if (!empty($data) && $data->count()) {
                $ind= 0;
                foreach ($data as $key => $v) {
                    $RechargeInfo[$ind]['phone'] = $v['phone'];
                    $RechargeInfo[$ind]['validity'] = Carbon::createFromFormat('d/m/Y', $v['validity'])->toDateString();
                    $RechargeInfo[$ind]['volume'] = $v['volume'];
                    $RechargeInfo[$ind]['amount'] = $v['amount'];
                    $ind++;
                }

                if (!empty($RechargeInfo)) {
                    $RechargeInfo = collect($RechargeInfo);
                    //return $RechargeInfo;

                    foreach ($RechargeInfo as $value):
                    $phone = $value['phone'];

                     $Device = Device::where('phone', $phone)->first();

                     if (is_null($Device)) {
                         $import_errors[] =  'This IMSI '.$phone." is not mapped with ".  $phone .", Recharging of ".$phone. " is Failed";

                     } else {

                         $recharge = Recharge::create([
                          'device_id' => $Device->id,
                          'phone' => (String)$value['phone'],
                          'amount' => floatval($value['amount']) ,
                          'validity'=>$value['validity'],
                          'volume' => floatval($value['volume']) ,
                          'recharged_at' => Carbon::now()->toDateString(),
                          'consumed' => 0,
                          'remained' => floatval($value['volume'])
                         ]);

                         //update device's balance

                         $Device->update([
                         'balance.consumed'=>    0,
                         'balance.volume'=>      floatval($value['volume']),
                         'balance.remained'=>    floatval($value['volume']),
                         'balance.validity'=>    Carbon::createFromFormat('Y-m-d', $value['validity'])->timestamp,
                         'balance.recharged_at'=> Carbon::now()->timestamp

                       ]);
                        //$user = $Device->user->name;
                        $sucessfull_recharges[] =$recharge->phone." Recharged by ".$recharge->amount." TK and Recharged Volume is ".$recharge->volume." MB";

                       }

                  endforeach;
                }
            } else {
                $import_errors []=  "Sheet is Empty";

                return view('car.excel_import')->with(['sucessfull_recharges'=>$sucessfull_recharges,'import_errors'=>$import_errors]);
            }
        } else {
            $import_errors[] = "Please Choose File";
            ///$sucessfull_recharges =[];
            return view('car.excel_import')->with(['sucessfull_recharges'=>[],'import_errors'=>$import_errors]);
        }

        return view('car.excel_import')->with(['sucessfull_recharges'=>$sucessfull_recharges,'import_errors'=>$import_errors]);

    }
}
