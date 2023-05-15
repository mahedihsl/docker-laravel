<?php

namespace App\Presenters;

use App\Transformers\CarDateTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CarDatePresenter.
 *
 * @package namespace App\Presenters;
 */
class CarDatePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CarDateTransformer();
    }
}
