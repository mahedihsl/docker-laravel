<?php

namespace App\Observers;

use App\Entities\GasCalibration;

class GasCalibrationObserver
{

    public function created(GasCalibration $model)
    {
        $model->device->update(['gas_method' => 1]);
    }

    public function deleting(GasCalibration $model)
    {
        if ($model->device->gas_calibration()->count() == 1) {
            $model->device->update(['gas_method' => 0]);
        }
    }
}
