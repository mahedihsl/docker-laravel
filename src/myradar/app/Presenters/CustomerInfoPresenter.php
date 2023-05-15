<?php

namespace App\Presenters;

use App\Transformers\CustomerInfoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CustomerInfoPresenter.
 *
 * @package namespace App\Presenters;
 */
class CustomerInfoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CustomerInfoTransformer();
    }
}
