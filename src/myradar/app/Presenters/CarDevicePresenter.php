<?php

namespace App\Presenters;

use App\Transformers\CarDeviceTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CarDevicePresenter.
 *
 * @package namespace App\Presenters;
 */
class CarDevicePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CarDeviceTransformer();
    }
}
