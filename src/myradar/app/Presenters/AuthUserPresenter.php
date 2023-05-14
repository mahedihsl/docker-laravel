<?php

namespace App\Presenters;

use App\Transformers\AuthUserTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class AuthUserPresenter.
 *
 * @package namespace App\Presenters;
 */
class AuthUserPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new AuthUserTransformer();
    }
}
