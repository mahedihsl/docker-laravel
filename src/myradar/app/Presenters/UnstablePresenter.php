<?php

namespace App\Presenters;

use App\Transformers\UnstableTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class UnstablePresenter.
 *
 * @package namespace App\Presenters;
 */
class UnstablePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new UnstableTransformer();
    }
}
