<?php

namespace App\Presenters;

use App\Transformers\FenceLogTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class FenceLogPresenter
 *
 * @package namespace App\Presenters;
 */
class FenceLogPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new FenceLogTransformer();
    }
}
