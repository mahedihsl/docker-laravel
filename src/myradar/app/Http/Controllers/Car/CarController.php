<?php

namespace App\Http\Controllers\Car;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCar;
use App\Http\Requests\UpdateCar;
use App\Contract\Repositories\CarRepository;
use App\Presenters\CarInfoPresenter;
use App\Presenters\CarDevicePresenter;
use App\Presenters\CarDetailsPresenter;
use App\Criteria\UserIdCriteria;
use App\Criteria\CarRegNoCriteria;
use App\Criteria\SharedUserCriteria;
use App\Criteria\PhoneNumberCriteria;
use App\Criteria\CommercialIdCriteria;
use App\Service\Facades\Package;
use App\Entities\Car;
use App\Entities\Device;
use App\Entities\PromoCode;
use App\Entities\PromoScheme;
use Carbon\Carbon;
use Excel;
use App\Transformers\VehicleExportTransformer;
use App\Service\Microservice\CarMicroservice;
use App\Service\Microservice\LocationMicroservice;
use Exception;

class CarController extends Controller
{
    /**
     * @var CarRepository
     */
    private $repository;
    private $carService;
    private $location;

    public function __construct(CarRepository $repository)
    {
        $this->repository = $repository;
        $this->location = new LocationMicroservice();
        $this->carService = new CarMicroservice();
    }

    public function index(Request $request)
    {
        return view('car.index');
    }

    public function search(Request $request)
    {
        $this->repository->setPresenter(CarDevicePresenter::class);

        if (strlen($regNo = $request->get('reg', ''))) {
            $this->repository->pushCriteria(new CarRegNoCriteria($regNo));
        }

        if (strlen($comId = $request->get('com', ''))) {
            $this->repository->pushCriteria(new CommercialIdCriteria($comId, true));
        }

        if (strlen($phone = $request->get('phone', ''))) {
            $this->repository->pushCriteria(new PhoneNumberCriteria($phone, true));
        }

        return response()->json($this->repository->with(['device'])->paginate());
    }

    /**
     * Car list of an User (including shared cars)
     * @param  Request $request [description]
     * @param  string  $userId  [description]
     * @return mixed            JSON response
     */
    public function all(Request $request, $userId)
    {
        $models = $this->repository
                        ->setPresenter(CarInfoPresenter::class)
                        ->pushCriteria(new UserIdCriteria($userId))
                        ->pushCriteria(new SharedUserCriteria($userId))
                        ->all();

        return response()->json($models,200);
    }

    public function show(Request $request, $id)
    {
        $this->repository->setPresenter(CarDetailsPresenter::class);
        $car = $this->repository->skipPresenter()->find($id);

        if ( ! is_null($car)) {
            return response()->json($car->presenter());
        }

        return response()->error('Car Not Found');
    }

    public function save(CreateCar $request)
    {
        $promo = $request->get('promo_key');
        $validation = ['status' => true, 'msg' => 'ok'];
        $car = null;

        if($promo){
          $validation = $this->validatePromo($promo);
        }

        if($validation['status']){
          $car = $this->repository->save(collect($request->all()));
          if ( ! is_null($car)) {
              return response()->json();
          }

          return response()->error();
        }

        return response()->error($validation['msg']);
    }

    public function update(UpdateCar $request)
    {
        $data = collect($request->all());

        if ( ! $request->user()->isAdmin()) {
            $data->forget('reg_no');
            $data->forget('services');
        }

        $this->repository->setPresenter(CarInfoPresenter::class);
        $car = $this->repository->skipPresenter()->change($data);

        if ( ! is_null($car)) {
            return response()->json($car->presenter());
        }

        return response()->error();
    }

    public function services(Request $request, $id)
    {
        $car = $this->repository->find($id);

        if ( ! is_null($car)) {
            $services = collect($car->services);
            $names = Package::getServiceNames($services);

            $items = $services->map(function($item, $i) use ($names) {
                return [
                    'tag' => $item,
                    'label' => $names[$i],
                ];
            });

            return response()->json($items);
        }

        return response()->error('Car Not Found');
    }

    public function packages(Request $request)
    {
        return response()->json([
            Package::basicCar(),
            Package::proCar(),
            Package::proCarIII(),
            Package::proCarII(),
            Package::basicBike(),
            Package::proBike(),
        ]);
    }

    public function toggleStatus(Request $request, $id)
    {
        $car = $this->repository->find($id);

        if ( ! is_null($car)) {
            $car->update([ 'status' => ($car->status + 1) % 2 ]);

            return response()->json();
        }

        return response()->error();
    }

    public function export(Request $request)
    {
      $data = Car::orderBy('created_at', 'desc')->get();

        Excel::create('Vehicles', function ($excel) use ($data) {
            $excel->sheet('data', function ($sheet) use ($data) {
                $data->transform(function ($item) {
                    $transformer = new VehicleExportTransformer();
                    return $transformer->transform($item);
                });

                $sheet->fromArray($data->toArray(), null, 'A1', false, true);
            });
        })->download('xls');

        return redirect()->back();
    }

    public function validatePromo(String $promoCode)
    {
      $promo = PromoCode::where('code', $promoCode)->first();

      if(is_null($promo)){
        return ['status' => false, 'msg' => 'wrong promo code'];
      }
      $valid_till = Carbon::createFromFormat('d M Y', $promo->promo_Scheme->valid_till);
      if($valid_till->lt(Carbon::today())){
        return ['status' => false, 'msg' => 'promo scheme date expired'];
      }

      return ['status' => true, 'msg' => 'promo valid'];
    }

    public function everything(Request $request)
    {
        return response()->json($this->carService->list());
    }

    public function lastLocation(Request $request)
    {
        try {
            $device = Device::where('car_id', $request->get('car_id'))->first();
          
            if (is_null($device)) {
                throw new Exception('No Device attached to this car');
            }

            return response()->json($this->location->latest($device->com_id));
        } catch (\Exception $e) {
            return response()->json([ 'message' => $e->getMessage() ], 400);
        }
    }

}
