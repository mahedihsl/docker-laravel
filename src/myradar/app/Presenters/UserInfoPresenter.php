<?php

namespace App\Presenters;

use App\Transformers\UserInfoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class UserInfoPresenter.
 *
 * @package namespace App\Presenters;
 */
class UserInfoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new UserInfoTransformer();
    }
}
