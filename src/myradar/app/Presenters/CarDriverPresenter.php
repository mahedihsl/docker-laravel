<?php

namespace App\Presenters;

use App\Transformers\CarDriverTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CarDriverPresenter.
 *
 * @package namespace App\Presenters;
 */
class CarDriverPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CarDriverTransformer();
    }
}
