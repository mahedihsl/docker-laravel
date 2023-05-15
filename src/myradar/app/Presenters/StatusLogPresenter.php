<?php

namespace App\Presenters;

use App\Transformers\StatusLogTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class StatusLogPresenter.
 *
 * @package namespace App\Presenters;
 */
class StatusLogPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new StatusLogTransformer();
    }
}
