<?php

namespace App\Presenters;

use App\Transformers\DrivingHourTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class MileagePresenter
 *
 * @package namespace App\Presenters;
 */
class DrivingHourPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new DrivingHourTransformer();
    }
}
