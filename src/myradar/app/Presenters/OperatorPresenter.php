<?php

namespace App\Presenters;

use App\Transformers\OperatorTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class OperatorPresenter
 *
 * @package namespace App\Presenters;
 */
class OperatorPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new OperatorTransformer();
    }
}
