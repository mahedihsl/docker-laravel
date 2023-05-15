<?php

namespace App\Presenters;

use App\Transformers\FuelCalibrationTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class FuelCalibrationPresenter.
 *
 * @package namespace App\Presenters;
 */
class FuelCalibrationPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new FuelCalibrationTransformer();
    }
}
