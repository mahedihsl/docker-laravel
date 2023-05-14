<?php

namespace App\Presenters;

use App\Transformers\PoiTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class PoiPresenter
 *
 * @package namespace App\Presenters;
 */
class PoiPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PoiTransformer();
    }
}
