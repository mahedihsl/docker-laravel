<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Car;


/**
 * Class EnterpriseCarTransformer
 * @package namespace App\Transformers;
 */

class EnterpriseCarTransformer extends TransformerAbstract
{
  /**
   * Transform the CarStatus entity
   * @param App\Entities\Car $model
   *
   * @return array
   */


   public function transform(Car $model)
   {

     $driver=$this->getDriver($model);

     return [
         'id' => $model->id,
         'reg_no' => $model->reg_no,
         'driver' => $driver,
         'deviceId' => is_null($model->device) ?  null : $model->device->id,
     ];
   }

   public function getDriver(Car $model)
   {
     if(is_null($model->driver)) {
         return [
             'id' => '',
             'name' => '--',
             'phone' => '--',
         ];
     }

     return [
       'id' => $model->driver->id,
       'name' => $model->driver->name,
       'phone' => $model->driver->phone,
     ];
   }
}
