<?php

namespace App\Presenters;

use App\Transformers\HealthTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class HealthPresenter
 *
 * @package namespace App\Presenters;
 */
class HealthPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new HealthTransformer();
    }
}
