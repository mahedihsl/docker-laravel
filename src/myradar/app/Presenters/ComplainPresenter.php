<?php

namespace App\Presenters;

use App\Transformers\ComplainTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ComplainPresenter.
 *
 * @package namespace App\Presenters;
 */
class ComplainPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ComplainTransformer();
    }
}
