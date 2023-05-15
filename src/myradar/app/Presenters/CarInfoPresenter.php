<?php

namespace App\Presenters;

use App\Transformers\CarInfoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CarInfoPresenter
 *
 * @package namespace App\Presenters;
 */
class CarInfoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CarInfoTransformer();
    }
}
