<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use App\Entities\User;
use App\Entities\Car;
/**
 * Class ComplainUserNameCriteria.
 *
 * @package namespace App\Criteria;
 */
class ComplainUserNameCriteria implements CriteriaInterface
{
  private $name;

  public function __construct($name)
  {
      $this->name = $name;
  }

    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $user_ids = User::where('name', 'like', '%'.$this->name.'%')
                    ->get()
                    ->map(function($item) {
                        return $item->id;
                    })
                    ->toArray();

        $car_ids = Car::whereIn('user_id',$user_ids)
                  ->get()
                  ->map(function($item) {
                      return $item->id;
                  })
                  ->toArray();
                  
        return $model->whereIn('car_id', $car_ids);
    }
}
