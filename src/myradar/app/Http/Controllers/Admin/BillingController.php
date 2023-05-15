<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\ActivationRepository;
use App\Criteria\LastUpdatedCriteria;
use App\Criteria\LastCreatedCriteria;
use App\Transformers\BillExportTransformer;
use App\Transformers\BillDrilldownExportTransformer;
use Excel;
use App\Entities\Payment;
use Carbon\Carbon;

class BillingController extends Controller
{
    /**
     * @var ActivationRepository
     */
    private $repository;

    public function __construct(ActivationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $this->repository->with(['car.payments'])->pushCriteria(new LastCreatedCriteria());

        return view('billing.index')->with([
            'items' => $this->repository->paginate(50),
        ]);
    }

    public function drilldown(Request $request)
    {
        $export = $request->get('export', '') == 'Export' ? TRUE : FALSE;

        $records = collect();
        $month = intval($request->get('month', '0'));
        $year = intval($request->get('year', '0'));
        $filter = intval($request->get('filter', '0'));

        if ($month == 0 || $year == 0 || $filter == 0) {
            return view('billing.drilldown')->with([
                'month' => 0,
                'year' => 0,
                'filter' => 1,
                'items' => $records,
            ]);
        } else {
            $date1 = Carbon::createFromDate($year, $month, 1);
            $date2 = Carbon::createFromDate($year, $month + 1, 1);
            $date1->setTime(0, 0,0);
            $date2->setTime(0, 0,0);

            if ($filter == 1) {
                $records = Payment::where('months', 'all', [[$month - 1, $year]])
                                ->orWhere('months', 'all', [[$month - 1, strval($year)]])
                                ->orderBy('created_at', 'desc')
                                ->with('car', 'user');
            } else {
                $records = Payment::where('paid_on', '>=', $date1)
                                ->where('paid_on', '<', $date2)
                                ->orderBy('created_at', 'desc')
                                ->with('car', 'user');
            }

            if ($export == 1) {
                $data = $records->get();
                $tp = $filter == 1 ? 'Billing Month' : 'Collection Month';
                $fileName = 'BillingDrilldown-'.$tp.'-'.$date1->format('M Y');
                Excel::create($fileName, function ($excel) use ($data, $filter, $date1) {
                    $excel->sheet('data', function ($sheet) use ($data, $filter, $date1) {
                        $data->transform(function ($payment) use ($filter, $date1) {
                            $transformer = new BillDrilldownExportTransformer();
                            return $transformer->transform($payment, $filter, $date1);
                        });

                        $sheet->fromArray($data->toArray(), null, 'A1', false, true);

                        // $sheet->row(1, function ($row) {
                        //     $row->BalancesetFontWeight('bold');
                        // });
                    });
                })->download('xlsx');
            } else {
                return view('billing.drilldown')->with([
                    'month' => $month,
                    'year' => $year,
                    'filter' => $filter,
                    'items' => $records->paginate(50),
                ]);
            }
        }
    }

    public function export(Request $request)
    {
        // $data = $this->repository
        //             ->pushCriteria(new LastCreatedCriteria())
        //             ->with(['car.payments'])
        //             ->all()
        //             ->filter(function($record) {
        //                 return ! is_null($record->car);
        //             });

        $data = $this->repository
    ->pushCriteria(new LastCreatedCriteria())
    ->with(['car.payments'])
    ->has('car') 
    ->get();

        Excel::create('FullBillingReport', function ($excel) use ($data) {
            $excel->sheet('data', function ($sheet) use ($data) {
                $data->transform(function ($activation) {
                    $transformer = new BillExportTransformer();
                    return $transformer->transform($activation);
                });

                $sheet->fromArray($data->toArray(), null, 'A1', false, true);
            });
        })->download('xlsx');
    }
}
