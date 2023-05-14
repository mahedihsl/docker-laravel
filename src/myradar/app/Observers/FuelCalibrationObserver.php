<?php

namespace App\Observers;

use App\Entities\FuelCalibration;

class FuelCalibrationObserver
{

    public function created(FuelCalibration $model)
    {
        $model->device->update(['fuel_method' => 1]);
    }

    public function deleting(FuelCalibration $model)
    {
        if ($model->device->fuel_calibration()->count() == 0) {
            $model->device->update(['fuel_method' => 0]);
        }
    }
}
