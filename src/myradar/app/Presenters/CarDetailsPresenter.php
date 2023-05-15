<?php

namespace App\Presenters;

use App\Transformers\CarDetailsTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CarDetailsPresenter.
 *
 * @package namespace App\Presenters;
 */
class CarDetailsPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CarDetailsTransformer();
    }
}
