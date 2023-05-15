<?php

namespace App\Presenters;

use App\Transformers\ThanaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ThanaPresenter
 *
 * @package namespace App\Presenters;
 */
class ThanaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ThanaTransformer();
    }
}
