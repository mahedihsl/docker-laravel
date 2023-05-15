<?php

namespace App\Presenters;

use App\Transformers\UserActivityTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class UserActivityPresenter.
 *
 * @package namespace App\Presenters;
 */
class UserActivityPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new UserActivityTransformer();
    }
}
