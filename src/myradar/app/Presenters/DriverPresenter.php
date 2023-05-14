<?php

namespace App\Presenters;

use App\Transformers\DriverTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class DriverPresenter.
 *
 * @package namespace App\Presenters;
 */
class DriverPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new DriverTransformer();
    }
}
