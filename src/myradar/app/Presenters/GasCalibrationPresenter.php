<?php

namespace App\Presenters;

use App\Transformers\GasCalibrationTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class GasCalibrationPresenter.
 *
 * @package namespace App\Presenters;
 */
class GasCalibrationPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new GasCalibrationTransformer();
    }
}
