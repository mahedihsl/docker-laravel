<?php

namespace App\Http\Controllers\Promotion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\PromoCodeRepository;
use App\Criteria\LastUpdatedCriteria;
use App\Entities\User;
use App\Entities\PromoCode;

class PromoCodeController extends Controller
{
  /**
   * @var PromoCodeRepository
   */
   private $repository;
    public function __construct(PromoCodeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function generate(Request $request)
    {
      while (true) {
          $num = rand(1000, 9999);
          $code = 'RADAR'.$num;
          if ( ! PromoCode::where('code', $code)->exists()) {
              return response()->ok([
                  'code' => $code,
              ]);
          }
      }
    }

    public function save(Request $request)
    {
      $this->repository->save(collect($request->all()));
      return response()->ok();
    }

    public function show(Request $request)
    {
      $this->repository->pushCriteria(new LastUpdatedCriteria());

      return response()->ok($this->repository->with(['user'])->paginate());
    }


}
