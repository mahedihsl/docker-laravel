<?php

namespace App\Presenters;

use App\Transformers\ActivationTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ActivationPresenter.
 *
 * @package namespace App\Presenters;
 */
class ActivationPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ActivationTransformer();
    }
}
