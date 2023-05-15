<?php

namespace App\Presenters;

use App\Transformers\PerformanceTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class PerformancePresenter.
 *
 * @package namespace App\Presenters;
 */
class PerformancePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PerformanceTransformer();
    }
}
